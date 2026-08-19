<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register - Warehouse System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Figtree, sans-serif;
            background: #eef5ff;
        }

        .register-page {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            background:
                linear-gradient(
                    135deg,
                    #eff6ff 0%,
                    #dbeafe 50%,
                    #eff6ff 100%
                );
        }

        /* =====================================================
           LES / BENTUK BIRU
           ===================================================== */

        .blue-shape {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .shape-1 {
            width: 420px;
            height: 420px;
            background: #bfdbfe;
            opacity: .55;
            top: -220px;
            left: -180px;
        }

        .shape-2 {
            width: 330px;
            height: 330px;
            background: #93c5fd;
            opacity: .35;
            top: -130px;
            right: -130px;
        }

        .shape-3 {
            width: 280px;
            height: 280px;
            background: #60a5fa;
            opacity: .18;
            bottom: -120px;
            left: -80px;
        }

        .shape-4 {
            width: 430px;
            height: 180px;
            background: #bfdbfe;
            opacity: .45;
            border-radius: 50%;
            bottom: -80px;
            right: -100px;
            transform: rotate(-15deg);
        }

        /* =====================================================
           CONTAINER
           ===================================================== */

        .register-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 430px;
        }

        /* =====================================================
           LOGO
           ===================================================== */

        .brand {
            text-align: center;
            margin-bottom: 18px;
        }

        .logo {
            width: 58px;
            height: 58px;
            margin: 0 auto 10px;

            background: #0f172a;
            color: white;

            border-radius: 14px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 22px;
            font-weight: 800;

            box-shadow:
                0 8px 20px rgba(15, 23, 42, .18);
        }

        .brand h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
        }

        .brand p {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 14px;
        }

        /* =====================================================
           CARD
           ===================================================== */

        .register-card {
            width: 100%;
            background: white;

            border-radius: 16px;

            border: 1px solid #dbe3ef;

            padding: 28px;

            box-shadow:
                0 15px 40px rgba(30, 64, 175, .15);
        }

        .card-title {
            margin-bottom: 22px;
        }

        .card-title h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
        }

        .card-title p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #64748b;
        }

        /* =====================================================
           ERROR
           ===================================================== */

        .error-box {
            margin-bottom: 18px;
            padding: 12px 14px;

            background: #fef2f2;
            border: 1px solid #fecaca;

            color: #b91c1c;

            border-radius: 9px;

            font-size: 13px;
        }

        .error-box ul {
            margin: 0;
            padding-left: 18px;
        }

        /* =====================================================
           FORM
           ===================================================== */

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;

            margin-bottom: 7px;

            font-size: 14px;
            font-weight: 700;

            color: #334155;
        }

        .form-group input {
            display: block;

            width: 100%;

            height: 44px;

            padding: 0 13px;

            border: 1px solid #cbd5e1;

            border-radius: 9px;

            background: white;

            color: #0f172a;

            font-size: 14px;

            outline: none;

            transition: .2s;
        }

        .form-group input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37, 99, 235, .12);
        }

        /* =====================================================
           BUTTON
           ===================================================== */

        .register-button {
            width: 100%;

            height: 45px;

            margin-top: 4px;

            border: none;

            border-radius: 9px;

            background: #2563eb;

            color: white;

            font-size: 14px;

            font-weight: 700;

            cursor: pointer;

            transition: .2s;
        }

        .register-button:hover {
            background: #1d4ed8;
        }

        /* =====================================================
           LOGIN
           ===================================================== */

        .login-link {
            text-align: center;

            margin-top: 20px;

            padding-top: 18px;

            border-top: 1px solid #e2e8f0;
        }

        .login-link p {
            margin: 0;

            font-size: 13px;

            color: #64748b;
        }

        .login-link a {
            display: inline-block;

            margin-top: 7px;

            color: #2563eb;

            text-decoration: none;

            font-size: 14px;

            font-weight: 700;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* =====================================================
           FOOTER
           ===================================================== */

        .footer {
            text-align: center;

            margin-top: 14px;

            font-size: 11px;

            color: #64748b;
        }

        /* =====================================================
           MOBILE
           ===================================================== */

        @media (max-width: 500px) {

            .register-page {
                padding: 20px 14px;
            }

            .register-container {
                max-width: 100%;
            }

            .register-card {
                padding: 22px;
            }

            .brand h1 {
                font-size: 18px;
            }

        }

    </style>

</head>


<body>

<div class="register-page">

    {{-- ================================================= --}}
    {{-- BACKGROUND BLUE --}}
    {{-- ================================================= --}}

    <div class="blue-shape shape-1"></div>

    <div class="blue-shape shape-2"></div>

    <div class="blue-shape shape-3"></div>

    <div class="blue-shape shape-4"></div>


    {{-- ================================================= --}}
    {{-- REGISTER --}}
    {{-- ================================================= --}}

    <div class="register-container">


        {{-- BRAND --}}
        <div class="brand">

            <div class="logo">
                SBA
            </div>

            <h1>
                PT SOLUSI BANGUN ANDALAS
            </h1>

            <p>
                Sistem Informasi Warehouse
            </p>

        </div>


        {{-- CARD --}}
        <div class="register-card">


            {{-- HEADER --}}
            <div class="card-title">

                <h2>
                    Buat Akun
                </h2>

                <p>
                    Daftarkan pengguna baru ke sistem warehouse
                </p>

            </div>


            {{-- ERROR --}}
            @if($errors->any())

                <div class="error-box">

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- FORM --}}
            <form
                method="POST"
                action="{{ route('register') }}"
            >

                @csrf


                {{-- NAMA --}}
                <div class="form-group">

                    <label for="name">
                        Nama
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Masukkan nama lengkap"
                    >

                </div>


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
                        autocomplete="username"
                        placeholder="Masukkan email"
                    >

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
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                    >

                </div>


                {{-- KONFIRMASI --}}
                <div class="form-group">

                    <label for="password_confirmation">
                        Konfirmasi Password
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Ulangi password"
                    >

                </div>


                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="register-button"
                >
                    Daftar User
                </button>


            </form>


            {{-- LOGIN --}}
            <div class="login-link">

                <p>
                    Sudah memiliki akun?
                </p>

                <a href="{{ route('login') }}">
                    ← Kembali ke Login
                </a>

            </div>


        </div>


        {{-- FOOTER --}}
        <div class="footer">

            © {{ date('Y') }} PT Solusi Bangun Andalas

        </div>


    </div>

</div>

</body>

</html>