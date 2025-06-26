<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SISMADAKPUSIP</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

       body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-image: url('{{ asset('images/watermark.png') }}');
    background-repeat: no-repeat;
    background-position: center center;
    background-size: contain; /* atau 'cover' tergantung kebutuhan */
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
     opacity: 95%; /* Atur transparansi */
}

        .login-container {
            display: flex;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            min-height: 500px;
        }

        .login-form-section {
            flex: 1;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .welcome-section {
            flex: 1;
            background: linear-gradient(135deg, #64c5e5 0%, #64e5ff 100%);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }

        .brand-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .brand-subtitle {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.4;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #333;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-input:focus {
            outline: none;
            border-color: #4CAF50;
            background: white;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .form-input.is-invalid {
            border-color: #dc3545;
            background: #fff5f5;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .login-btn {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, #4caaaf 0%, #66c1ee 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #e1e5e9;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #666;
        }

        .social-btn:hover {
            border-color: #4CAF50;
            color: #4CAF50;
            transform: translateY(-2px);
        }

        .welcome-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .welcome-text {
            font-size: 1rem;
            line-height: 1.6;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                margin: 1rem;
                max-width: 400px;
            }

            .welcome-section {
                order: -1;
                min-height: 200px;
            }

            .login-form-section {
                padding: 2rem;
            }

            .welcome-title {
                font-size: 1.5rem;
            }

            .welcome-icon {
                font-size: 3rem;
            }
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
            color: #999;
            font-size: 0.8rem;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e5e9;
            z-index: 1;
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form-section">
            <div>
                <h2 class="brand-title">SISMADAKPUSIP</h2>
                <p class="brand-subtitle">Sistem Informasi Surat Masuk dan Keluar<br>Perpustakaan dan Kearsipan Provinsi Lampung</p>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               class="form-input @error('email') is-invalid @enderror"
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               placeholder="Masukkan email Anda">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="kata_sandi" class="form-label">Kata Sandi</label>
                        <input type="password" 
                               class="form-input @error('kata_sandi') is-invalid @enderror"
                               id="kata_sandi" 
                               name="kata_sandi" 
                               required 
                               placeholder="Masukkan kata sandi">
                        @error('kata_sandi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="login-btn">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                </form>

            </div>
        </div>

        <div class="welcome-section">
            <div>
                <i class="fas fa-archive welcome-icon"></i>
                <h3 class="welcome-title">Selamat Datang!</h3>
            </div>
        </div>
    </div>

    <script>
        // Form validation enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-input');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                        this.classList.remove('is-invalid');
                    }
                });
            });

            // Social login placeholders
            document.querySelectorAll('.social-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Fitur login sosial akan segera tersedia!');
                });
            });
        });
    </script>
</body>
</html>