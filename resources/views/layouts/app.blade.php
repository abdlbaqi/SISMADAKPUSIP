<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul') - SISMADAKPUSIP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }
        .nav-link:hover, .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: none;
        }
        
        /* Custom dropdown styles untuk sidebar */
        .dropdown-sidebar {
            position: relative;
            width: 100%;
        }
        
        .dropdown-sidebar .dropdown-toggle {
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            color: rgba(255, 255, 255, 0.8);
            padding: 10px 15px;
            transition: all 0.3s;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }
        
        .dropdown-sidebar .dropdown-toggle:hover,
        .dropdown-sidebar .dropdown-toggle.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        
        .dropdown-sidebar .dropdown-toggle::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            border: none;
            transition: transform 0.3s;
        }
        
        .dropdown-sidebar .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }
        
        .dropdown-sidebar .dropdown-menu {
            position: static;
            background: rgba(0, 0, 0, 0.1);
            border: none;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
            margin-top: 0;
            border-radius: 0;
            width: 100%;
            padding: 0;
        }
        
        .dropdown-sidebar .dropdown-item {
            color: rgba(255, 255, 255, 0.7);
            padding: 8px 15px 8px 35px;
            font-size: 0.9em;
            border: none;
            background: none;
            transition: all 0.3s;
            display: block;
            text-decoration: none;
        }
        
        .dropdown-sidebar .dropdown-item:hover,
        .dropdown-sidebar .dropdown-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .dropdown-sidebar .dropdown-item:focus {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3">
                    <h5 class="text-white text-center mb-4">SISMADAKPUSIP</h5>
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Beranda
                        </a>
                        
                        <!-- Dropdown Surat Masuk -->
                        <div class="dropdown-sidebar">
                            <button class="dropdown-toggle {{ request()->routeIs('surat-masuk.*') ? 'active' : '' }}" 
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span><i class="fas fa-inbox me-2"></i> Surat Masuk</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('surat-masuk.create') ? 'active' : '' }}" 
                                       href="{{ route('surat-masuk.create') }}">
                                        <i class="fas fa-plus me-2"></i> Registrasi Surat Masuk
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('surat-masuk.index') ? 'active' : '' }}" 
                                       href="{{ route('surat-masuk.index') }}">
                                        <i class="fas fa-list me-2"></i> Daftar Surat Masuk
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('surat-masuk.arsip') ? 'active' : '' }}" 
                                       href="{{ route('surat-masuk.arsip') ?? '#' }}">
                                        <i class="fas fa-archive me-2"></i> Arsip Surat Masuk
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Dropdown Surat Keluar -->
                        <div class="dropdown-sidebar">
                            <button class="dropdown-toggle {{ request()->routeIs('surat-keluar.*') ? 'active' : '' }}" 
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span><i class="fas fa-paper-plane me-2"></i> Surat Keluar</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('surat-keluar.index') ? 'active' : '' }}" 
                                       href="{{ route('surat-keluar.index') }}">
                                        <i class="fas fa-list me-2"></i> Daftar Surat Keluar
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('surat-keluar.create') ? 'active' : '' }}" 
                                       href="{{ route('surat-keluar.create') }}">
                                        <i class="fas fa-plus me-2"></i> Tambah Surat Keluar
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('surat-keluar.arsip') ? 'active' : '' }}" 
                                       href="{{ route('surat-keluar.arsip') ?? '#' }}">
                                        <i class="fas fa-archive me-2"></i> Arsip Surat Keluar
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        {{-- Disposisi jika diperlukan --}}
                        {{-- <a class="nav-link {{ request()->routeIs('disposisi.*') ? 'active' : '' }}" href="{{ route('disposisi.index') }}">
                            <i class="fas fa-share-alt me-2"></i> Disposisi
                        </a> --}}
                        
                        @if(auth()->user()->peran === 'admin')
                        <hr class="my-3" style="border-color: rgba(255, 255, 255, 0.3);">
                        
                        <!-- Dropdown Master Data (untuk admin) -->
                        <div class="dropdown-sidebar">
                            <button class="dropdown-toggle {{ request()->routeIs(['kategori-surat.*', 'pengguna.*']) ? 'active' : '' }}" 
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span><i class="fas fa-cogs me-2"></i> Master Data</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('kategori-surat.*') ? 'active' : '' }}" 
                                       href="{{ route('kategori-surat.index') }}">
                                        <i class="fas fa-tags me-2"></i> Jenis Surat
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('pengguna.*') ? 'active' : '' }}" 
                                       href="{{ route('pengguna.index') }}">
                                        <i class="fas fa-users me-2"></i> Pengguna
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @endif
                        
                        <hr class="my-3" style="border-color: rgba(255, 255, 255, 0.3);">
                        
                        <!-- Dropdown Laporan -->
                        <div class="dropdown-sidebar">
                            <button class="dropdown-toggle {{ request()->routeIs('laporan.*') ? 'active' : '' }}" 
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span><i class="fas fa-chart-bar me-2"></i> Laporan</span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}" 
                                       href="{{ route('laporan.index') }}">
                                        <i class="fas fa-chart-line me-2"></i> Laporan Umum
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('laporan.surat-masuk') ? 'active' : '' }}" 
                                       href="{{ route('laporan.surat-masuk') ?? '#' }}">
                                        <i class="fas fa-inbox me-2"></i> Laporan Surat Masuk
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('laporan.surat-keluar') ? 'active' : '' }}" 
                                       href="{{ route('laporan.surat-keluar') ?? '#' }}">
                                        <i class="fas fa-paper-plane me-2"></i> Laporan Surat Keluar
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center p-3 bg-white border-bottom">
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

                <!-- Content -->
                <div class="p-4">
                    @if(session('sukses'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('sukses') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Pastikan Bootstrap JS sudah dimuat
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded'); // Debug
            
            // Cek apakah ada dropdown item yang aktif dan buka parent dropdown
            const activeDropdownItems = document.querySelectorAll('.dropdown-sidebar .dropdown-item.active');
            
            activeDropdownItems.forEach(function(item) {
                const parentDropdown = item.closest('.dropdown-sidebar');
                const dropdownToggle = parentDropdown.querySelector('.dropdown-toggle');
                const dropdownMenu = parentDropdown.querySelector('.dropdown-menu');
                
                if (dropdownToggle && dropdownMenu) {
                    dropdownToggle.setAttribute('aria-expanded', 'true');
                    dropdownMenu.classList.add('show');
                }
            });
            
            // Manual toggle untuk dropdown jika Bootstrap tidak bekerja
            const dropdownToggles = document.querySelectorAll('.dropdown-sidebar .dropdown-toggle');
            
            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Dropdown clicked'); // Debug
                    
                    const parentDropdown = this.closest('.dropdown-sidebar');
                    const dropdownMenu = parentDropdown.querySelector('.dropdown-menu');
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    
                    // Close all other dropdowns
                    dropdownToggles.forEach(function(otherToggle) {
                        if (otherToggle !== toggle) {
                            const otherParent = otherToggle.closest('.dropdown-sidebar');
                            const otherMenu = otherParent.querySelector('.dropdown-menu');
                            otherToggle.setAttribute('aria-expanded', 'false');
                            otherMenu.classList.remove('show');
                        }
                    });
                    
                    // Toggle current dropdown
                    if (isExpanded) {
                        this.setAttribute('aria-expanded', 'false');
                        dropdownMenu.classList.remove('show');
                    } else {
                        this.setAttribute('aria-expanded', 'true');
                        dropdownMenu.classList.add('show');
                    }
                });
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown-sidebar')) {
                    dropdownToggles.forEach(function(toggle) {
                        const parentDropdown = toggle.closest('.dropdown-sidebar');
                        const dropdownMenu = parentDropdown.querySelector('.dropdown-menu');
                        toggle.setAttribute('aria-expanded', 'false');
                        dropdownMenu.classList.remove('show');
                    });
                }
            });
        });
    </script>
    
    @stack('scripts')
    <!-- Bootstrap JS Bundle (dengan Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>