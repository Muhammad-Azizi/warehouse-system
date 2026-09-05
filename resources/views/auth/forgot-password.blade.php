<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Password - Warehouse System</title>

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

                {{-- HEADER --}}
                <div class="login-header">

                    <h2>
                        Lupa Password?
                    </h2>

                    <p>
                        Masukkan email Anda untuk mendapatkan
                        link reset password.
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
                        Email yang Anda masukkan tidak ditemukan.
                    </div>

                @endif


                {{-- FORM --}}
                <form method="POST" action="{{ route('password.email') }}">

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
                            autocomplete="email"
                            placeholder="Masukkan email"
                        >

                        @error('email')

                            <span class="field-error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- BUTTON --}}
                    <button
                        type="submit"
                        class="login-button"
                    >
                        KIRIM LINK RESET PASSWORD
                    </button>

                </form>


                {{-- KEMBALI KE LOGIN --}}
                <div class="register-text">

                    <span>
                        Sudah ingat password?
                    </span>

                    <a href="{{ route('login') }}">
                        Kembali ke Login
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>