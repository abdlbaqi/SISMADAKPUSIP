<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul') SISMADAKPUSIP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Watermark Background */
        .watermark-bg {
            position: relative;
            background-color: #f8f9fa;
        }
        
     .watermark-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url('{{ asset('images/watermark.png') }}'); /* Pastikan file ada di /public/images/ */
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 50%; /* Gunakan 'cover' jika ingin menutupi penuh meski terpotong */
    opacity: 50%; /* Atur transparansi */
    pointer-events: none;
    z-index: 1;
}

      
        .sidebar {
            height: 100vh; /* Gunakan height bukan min-height */
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding: 0;
            width: 320px; /* Diperlebar dari default */
            min-width: 320px;
            position: fixed; /* Tetap fixed */
            top: 0;
            left: 0;
            z-index: 1000;
            overflow-y: auto; /* Pastikan overflow-y auto */
            overflow-x: hidden; /* Hindari horizontal scroll */
            display: flex;
            flex-direction: column; /* Gunakan flexbox */
        }
        
        .sidebar-header {
            background-color: #fff;
            padding: 25px 20px;
            border-bottom: 1px solid #dee2e6;
            text-align: center;
            position: relative;
            z-index: 11;
            flex-shrink: 0; /* Jangan shrink header */
        }
        
        .sidebar-header .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: nowrap;
        }
        
        .sidebar-header .logo-container img {
            max-height: 80px;
            max-width: 80px;
            flex-shrink: 0;
        }
        
        .sidebar-header .logo-container h4 {
            margin: 0;
            font-weight: bold;
            color: #007bff;
            font-size: 1.5rem;
            line-height: 1.2;
            flex-shrink: 0;
        }
        
        .sidebar-header h6 {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 10px 0;
            font-weight: 600;
            line-height: 1.4;
        }
        
        .sidebar-header small {
            color: #6c757d;
            font-size: 0.8rem;
            line-height: 1.3;
            display: block;
            margin-top: 8px;
        }
        
        .sidebar-content {
            padding: 20px 0;
            position: relative;
            z-index: 11;
            flex: 1; /* Ambil sisa ruang yang tersedia */
            overflow-y: auto; /* Scroll di content area */
            min-height: 0; /* Penting untuk flexbox scrolling */
        }
        
        .nav-link {
            color: #495057;
            padding: 14px 25px;
            border: none;
            background: none;
            text-decoration: none;
            display: flex;
            align-items: center;
            width: 100%;
            font-size: 0.95rem;
            transition: all 0.2s;
            white-space: nowrap;
            position: relative;
            z-index: 11;
        }
        
        .nav-link:hover {
            background-color: rgba(233, 236, 239, 0.8);
            color: #495057;
        }
        
        .nav-link.active {
            background-color: rgba(0, 123, 255, 0.9);
            color: white;
        }
        
        .nav-link i {
            width: 22px;
            text-align: center;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
            margin-left: 320px; /* Sesuaikan dengan lebar sidebar */
            width: calc(100% - 320px);
            position: relative;
        }
        
        /* Content area dengan watermark */
        .content-area {
            position: relative;
            z-index: 1;
            background-color: transparent;
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: none;
            background-color: rgba(255, 255, 255, 0.95);
            position: relative;
            z-index: 2;
        }
        
        /* Header dengan background putih solid */
        .main-header {
            background-color: rgba(255, 255, 255, 0.98);
            position: relative;
            z-index: 10;
            backdrop-filter: blur(2px);
        }
        
        /* Dropdown Styles */
        .dropdown-sidebar {
            width: 100%;
        }
        
        .dropdown-sidebar .dropdown-toggle {
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            color: #495057;
            padding: 14px 25px;
            transition: all 0.2s;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-size: 0.95rem;
            white-space: nowrap;
            position: relative;
            z-index: 11;
        }
        
        .dropdown-sidebar .dropdown-toggle:hover {
            background-color: rgba(233, 236, 239, 0.8);
            color: #495057;
        }
        
        .dropdown-sidebar .dropdown-toggle.active {
            background-color: rgba(0, 123, 255, 0.9);
            color: white;
        }
        
        .dropdown-sidebar .dropdown-toggle::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            border: none;
            transition: transform 0.2s;
            font-size: 0.8rem;
            flex-shrink: 0;
        }
        
        .dropdown-sidebar .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }
        
        .dropdown-sidebar .dropdown-menu {
            position: static;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            box-shadow: none;
            margin: 0;
            border-radius: 0;
            width: 100%;
            padding: 0;
            border-left: 3px solid #007bff;
            position: relative;
            z-index: 11;
            display: none; /* Default hidden */
        }
        
        .dropdown-sidebar .dropdown-menu.show {
            display: block;
        }
        
        .dropdown-sidebar .dropdown-item {
            color: #6c757d;
            padding: 12px 25px 12px 50px;
            font-size: 0.9rem;
            border: none;
            background: none;
            transition: all 0.2s;
            display: block;
            text-decoration: none;
            white-space: nowrap;
            position: relative;
            z-index: 11;
        }
        
        .dropdown-sidebar .dropdown-item:hover {
            color: #495057;
            background-color: rgba(248, 249, 250, 0.8);
        }
        
        .dropdown-sidebar .dropdown-item.active {
            color: #007bff;
            background-color: rgba(248, 249, 250, 0.8);
            font-weight: 500;
        }
        
        .dropdown-sidebar .dropdown-item:focus {
            color: #495057;
            background-color: rgba(248, 249, 250, 0.8);
        }
        
        .dropdown-sidebar .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            flex-shrink: 0;
        }
        
        .submenu {
            background-color: rgba(255, 255, 255, 0.95);
        }
        
        .sidebar-section {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 18px;
            margin-bottom: 18px;
        }
        
        .sidebar-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .sidebar-section h6 {
            padding: 0 25px;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.75rem;
            margin-bottom: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 11;
        }
        
        /* Alert dengan background yang lebih solid */
        .alert {
            background-color: rgba(255, 255, 255, 0.95);
            position: relative;
            z-index: 3;
        }
        
        /* Scrollbar styling untuk sidebar - Diperbaiki */
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Scrollbar untuk sidebar-content juga */
        .sidebar-content::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar-content::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar-content::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .sidebar-content::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        .me-custom {
            margin-right: -10px; /* atau 2px jika lebih presisi */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -320px;
                z-index: 1050;
                transition: left 0.3s ease;
                height: 100vh;
                overflow-y: auto;
            }
            
            .sidebar.show {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .sidebar-header .logo-container {
                flex-direction: column;
                gap: 10px;
            }
            
            .sidebar-header .logo-container h4 {
                font-size: 1.2rem;
            }
        }
        
        /* Fixed positioning for sidebar */
        .container-fluid {
            padding: 0;
        }

        /* Tambahan untuk memastikan scroll berfungsi */
        html, body {
            height: 100%;
            overflow-x: hidden;
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
           <div class="sidebar">
<div class="sidebar-header text-center">
   <div class="logo-container d-flex align-items-center mb-3">
    <img src="{{ asset('images/lampung.png') }}" alt="Logo Dinas"
     class="img-fluid me-custom" style="height: 60px; width: auto;">

    <h4 class="mb-0 fw-bold text-primary">SISMADAKPUSIP</h4>
</div>

    <h6 class="">
        SISTEM INFORMASI SURAT MASUK DAN SURAT KELUAR PERPUSTAKAAN DAN KEARSIPAN
    </h6>
</div>
    
    <div class="sidebar-content">
        <nav class="nav flex-column">
            <div class="sidebar-section">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i> Beranda
                </a>
            </div>

            <div class="sidebar-section">
                <h6>PENCIPTAAN ARSIP</h6>
                
                <!-- Naskah Masuk -->
                <div class="dropdown-sidebar">
                   <button class="dropdown-toggle {{ request()->routeIs('surat-masuk.*') || request()->routeIs('disposisi.*') ? 'active' : '' }}" 
                            type="button" data-target="menuSuratMasuk">
                        <span><i class="fas fa-inbox"></i> Naskah Masuk</span>
                    </button>
                    <div class="dropdown-menu {{ request()->routeIs('surat-masuk.*') || request()->routeIs('disposisi.*') ? 'show' : '' }}" id="menuSuratMasuk">
                        <ul class="submenu list-unstyled mb-0">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('surat-masuk.create') ? 'active' : '' }}" 
                                href="{{ route('surat-masuk.create') }}">
                                    <i class="fas fa-plus"></i> Registrasi Surat Masuk
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('surat-masuk.index') ? 'active' : '' }}" 
                                href="{{ route('surat-masuk.index') }}">
                                    <i class="fas fa-list"></i> Daftar Surat Masuk
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('disposisi.*') ? 'active' : '' }}" 
                                href="{{ route('disposisi.index') }}">
                                    <i class="fas fa-share-alt"></i> Disposisi
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Naskah Keluar -->
                <div class="dropdown-sidebar">
                    <button class="dropdown-toggle {{ request()->routeIs('surat-keluar.*') ? 'active' : '' }}" 
                            type="button" data-target="menuSuratKeluar">
                        <span><i class="fas fa-paper-plane"></i> Naskah Keluar</span>
                    </button>
                    <div class="dropdown-menu {{ request()->routeIs('surat-keluar.*') ? 'show' : '' }}" id="menuSuratKeluar">
                        <ul class="submenu list-unstyled mb-0">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('surat-keluar.index') ? 'active' : '' }}" 
                                   href="{{ route('surat-keluar.index') }}">
                                    <i class="fas fa-list"></i> Daftar Surat Keluar
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('surat-keluar.create') ? 'active' : '' }}" 
                                   href="{{ route('surat-keluar.create') }}">
                                    <i class="fas fa-plus"></i> Tambah Surat Keluar
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('surat-keluar.arsip') ? 'active' : '' }}" 
                                   href="{{ route('surat-keluar.arsip') }}">
                                    <i class="fas fa-archive"></i> Arsip Surat Keluar
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(auth()->user()->peran === 'admin')
            <div class="sidebar-section">
                <h6>MASTER</h6>
                
                <!-- Master Data -->
                <div class="dropdown-sidebar">
                    <button class="dropdown-toggle {{ request()->routeIs('kategori-surat.*') || request()->routeIs('pengguna.*') ? 'active' : '' }}" 
                            type="button" data-target="menuMasterData">
                        <span><i class="fas fa-cogs"></i> Master Data</span>
                    </button>
                    <div class="dropdown-menu {{ request()->routeIs('kategori-surat.*') || request()->routeIs('pengguna.*') ? 'show' : '' }}" id="menuMasterData">
                        <ul class="submenu list-unstyled mb-0">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('kategori-surat.*') ? 'active' : '' }}" 
                                   href="{{ route('kategori-surat.index') }}">
                                    <i class="fas fa-tags"></i> Jenis Surat
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('pengguna.*') ? 'active' : '' }}" 
                                   href="{{ route('pengguna.index') }}">
                                    <i class="fas fa-users"></i> Pengguna
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="sidebar-section">
                <!-- Laporan -->
                <div class="dropdown-sidebar">
                    <button class="dropdown-toggle {{ request()->routeIs('laporan.*') ? 'active' : '' }}" 
                            type="button" data-target="menuLaporan">
                        <span><i class="fas fa-chart-bar"></i> Laporan</span>
                    </button>
                    <div class="dropdown-menu {{ request()->routeIs('laporan.*') ? 'show' : '' }}" id="menuLaporan">
                        <ul class="submenu list-unstyled mb-0">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}" 
                                   href="{{ route('laporan.index') }}">
                                    <i class="fas fa-chart-line"></i> Laporan Umum
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('laporan.surat-masuk') ? 'active' : '' }}" 
                                   href="{{ route('laporan.surat-masuk') }}">
                                    <i class="fas fa-inbox"></i> Laporan Surat Masuk
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('laporan.surat-keluar') ? 'active' : '' }}" 
                                   href="{{ route('laporan.surat-keluar') }}">
                                    <i class="fas fa-paper-plane"></i> Laporan Surat Keluar
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </nav>
    </div>
</div>

            <!-- Main Content dengan Watermark -->
            <div class="main-content watermark-bg">
                <!-- Header -->
                <div class="main-header d-flex justify-content-between align-items-center p-3 border-bottom">
                    <h4 class="mb-0">@yield('judul')</h4>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-2"></i>{{ auth()->user()->nama }}
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('profil') ?? '#' }}">
                                    <i class="fas fa-user-cog me-2"></i>Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('keluar') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="content-area p-4">
                    @if(session('sukses'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('sukses') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil semua dropdown toggle button
        const dropdownToggles = document.querySelectorAll('.dropdown-sidebar .dropdown-toggle');

        dropdownToggles.forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                
                // Ambil target menu dari data-target attribute
                const targetId = this.getAttribute('data-target');
                const targetMenu = document.getElementById(targetId);
                
                if (targetMenu) {
                    // Cek apakah menu sedang terbuka
                    const isOpen = targetMenu.classList.contains('show');
                    
                    // Toggle menu
                    if (isOpen) {
                        // Tutup menu
                        targetMenu.classList.remove('show');
                        this.setAttribute('aria-expanded', 'false');
                    } else {
                        // Buka menu
                        targetMenu.classList.add('show');
                        this.setAttribute('aria-expanded', 'true');
                    }
                }
            });
        });

        // Auto buka dropdown jika ada item aktif di dalamnya
        const activeItems = document.querySelectorAll('.dropdown-item.active');
        activeItems.forEach(function (item) {
            const parentDropdown = item.closest('.dropdown-sidebar');
            if (parentDropdown) {
                const toggle = parentDropdown.querySelector('.dropdown-toggle');
                const menu = parentDropdown.querySelector('.dropdown-menu');
                if (toggle && menu) {
                    toggle.setAttribute('aria-expanded', 'true');
                    menu.classList.add('show');
                }
            }
        });
        
        // Auto buka dropdown untuk toggle yang sudah active
        const activeToggles = document.querySelectorAll('.dropdown-toggle.active');
        activeToggles.forEach(function (toggle) {
            const targetId = toggle.getAttribute('data-target');
            const targetMenu = document.getElementById(targetId);
            if (targetMenu) {
                toggle.setAttribute('aria-expanded', 'true');
                targetMenu.classList.add('show');
            }
        });
    });
    </script>

    <!-- Bootstrap JS Bundle (dengan Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>