<?php


namespace App\Exports;

use App\Models\SuratMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SuratMasukExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $search;
    protected $no = 1;
    
    public function __construct($search = null)
    {
        $this->search = $search;
    }

    /**
     * Ambil data untuk export
     */
    public function collection()
    {
        $query = SuratMasuk::with('kategori');
        
        // Jika ada pencarian, filter data
        if ($this->search) {
            $query->where('nomor_surat', 'like', '%' . $this->search . '%');
        }
        
        return $query->orderBy('tanggal_diterima', 'desc')->get();
    }

    /**
     * Header kolom Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'No. Naskah',
            'Nama Pengirim',
            'Jabatan',
            'Instansi Pengirim',
            'Hal',
            'Isi Ringkas',
            'Jenis Surat',
            'Sifat Surat',
            'Tanggal Surat',
            'Tanggal Surat Diterima',
            'Unit Disposisi',
            'Nama Surat',
        ];
    }

    /**
     * Mapping data untuk setiap baris
     */
    public function map($row): array
{
    return [
        $this->no++,
        $row->nomor_surat,
        $row->nama_pengirim,
        $row->jabatan_pengirim,
        $row->instansi_pengirim,
       Str::limit($row->perihal, 100),     
        Str::limit($row->isi_ringkas, 100),
        $row->kategori->nama_kategori,
        ucfirst($row->sifat_surat),
        \Carbon\Carbon::parse($row->tanggal_surat)->format('d-m-Y'),
        \Carbon\Carbon::parse($row->tanggal_diterima)->format('d-m-Y'),
         ucwords(str_replace('_', ' ', $row->unit_disposisi)),
        $row->file_surat ? preg_replace('/^\d+_/', '', basename($row->file_surat)) : '-'
    ];
}


    /**
     * Styling untuk Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0d6efd'], // Warna biru primary
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Style untuk semua data
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:M' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Center alignment untuk kolom nomor dan tanggal
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J2:K' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('F2:F' . $lastRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('G2:G' . $lastRow)->getAlignment()->setWrapText(true);

        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);


        return [];
    }
}
