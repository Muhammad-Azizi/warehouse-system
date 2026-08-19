@php
    $logoSource = 'C:/Users/dayah/.gemini/antigravity-ide/brain/6e57313c-36b4-4b86-8e9a-26519a1d524a/media__1786259501549.png';
    $logoDest = public_path('images/logo-sba.png');
    if (file_exists($logoSource)) {
        if (!is_dir(dirname($logoDest))) {
            mkdir(dirname($logoDest), 0755, true);
        }
        copy($logoSource, $logoDest);
    }
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Warehouse System</title>

    @vite(['resources/css/app.css'])
</head>

<body>

    <div class="login-page">

        {{-- ================================
             BAGIAN KIRI
        ================================= --}}

        <div class="login-left">

            <div class="left-content">

                {{-- LOGO --}}
                <div class="brand-logo">
                    <img
                        src="{{ asset('images/logo-sba.png') }}"
                        alt="Solusi Bangun Andalas"
                    >
                </div>

                {{-- JUDUL --}}
                <div class="warehouse-title">

                    <h1>WAREHOUSE SYSTEM</h1>

                    <p>
                        Sistem Informasi Warehouse
                    </p>

                </div>

                {{-- ICON --}}
                <div class="warehouse-icon">
                    📦
                </div>

                {{-- DESKRIPSI --}}
                <div class="warehouse-description">

                    <p>
                        Sistem informasi untuk membantu pengelolaan
                        persediaan material, barang masuk, barang keluar,
                        picking list dan laporan warehouse.
                    </p>

                </div>

            </div>

            {{-- COPYRIGHT --}}
            <div class="left-footer">

                © {{ date('Y') }} PT Solusi Bangun Andalas

            </div>

        </div>


        {{-- ================================
             BAGIAN KANAN
        ================================= --}}

        <div class="login-right">

            <div class="login-card">

                {{-- JUDUL LOGIN --}}
                <div class="login-header">

                    <h2>
                        Selamat Datang
                    </h2>

                    <p>
                        Silakan masuk untuk mengakses
                        Warehouse System
                    </p>

                </div>


                {{-- STATUS --}}
                @if (session('status'))

                    <div class="success-message">
                        {{ session('status') }}
                    </div>

                @endif


                {{-- ERROR --}}
                @if ($errors->any())

                    <div class="error-message">
                        Email atau password yang Anda masukkan salah.
                    </div>

                @endif


                {{-- FORM LOGIN --}}
                <form method="POST" action="{{ route('login') }}">

                    @csrf


                    {{-- EMAIL --}}
                    <div class="form-group">

                        <label for="email">
                            Email
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Masukkan email"
                        >

                        @error('email')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- PASSWORD --}}
                    <div class="form-group">

                        <label for="password">
                            Password
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                        >

                        @error('password')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- REMEMBER + FORGOT --}}
                    <div class="login-options">

                        <label class="remember">

                            <input
                                type="checkbox"
                                name="remember"
                            >

                            <span>
                                Ingat saya
                            </span>

                        </label>


                        @if (Route::has('password.request'))

                            <a href="{{ route('password.request') }}">
                                Lupa password?
                            </a>

                        @endif

                    </div>


                    {{-- LOGIN BUTTON --}}
                    <button
                        type="submit"
                        class="login-button"
                    >
                        LOGIN
                    </button>

                </form>


                {{-- REGISTER --}}
                @if (Route::has('register'))

                    <div class="register-text">

                        <span>
                            Belum memiliki akun?
                        </span>

                        <a href="{{ route('register') }}">
                            Buat akun
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</body>

</html>