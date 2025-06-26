<?php


namespace App\Exports;

use App\Models\Suratkeluar;
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

class SuratkeluarExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
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
        $query = Suratkeluar::with('kategori');
        
        // Jika ada pencarian, filter data
        if ($this->search) {
            $query->where('nomor_surat', 'like', '%' . $this->search . '%');
        }
        
        return $query->orderBy('tanggal_surat', 'desc')->get();
    }

    /**
     * Header kolom Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Nomor Surat',
            'Tanggal Surat',
            'Jenis Surat',
            'Sifat Surat',
            'Klasifikasi',
            'Hal',
            'Tujuan Surat',
            'Nama Penandatangan',
            'Dikirim Melalui',
            'Nama File',
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
            \Carbon\Carbon::parse($row->tanggal_surat)->format('d-m-Y'),
            $row->kategori->nama_kategori,
            ucfirst($row->sifat_surat),
            $row->klasifikasi,
            Str::limit($row->hal, 100),
            Str::limit($row->tujuan_surat, 100),
            $row->nama_penandatangan,
            $row->dikirimkan_melalui,
            $row->file_surat ? preg_replace('/^\d+_/', '', basename($row->file_surat)) : '-',
        ];
    }

    /**
     * Styling untuk Excel
     */
    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // Header styling
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0d6efd'],
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

        // All borders and vertical align
        $sheet->getStyle('A1:K' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Center alignment for No & Tanggal
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C2:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }
}
