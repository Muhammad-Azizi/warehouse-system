<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Password - Warehouse System</title>

    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center">

    <div class="w-full max-w-md px-6">

        {{-- LOGO / HEADER --}}
        <div class="text-center mb-5">

            <div class="inline-flex items-center justify-center
                        w-12 h-12 rounded-xl
                        bg-slate-900 text-white
                        font-bold text-sm shadow-md">
                SBA
            </div>

            <h1 class="mt-3 text-lg font-semibold text-slate-900">
                PT SOLUSI BANGUN ANDALAS
            </h1>

            <p class="text-xs text-slate-500 mt-1">
                Sistem Informasi Warehouse
            </p>

        </div>


        {{-- CARD --}}
        <div class="bg-white rounded-xl shadow-lg p-6">

            {{-- TITLE --}}
            <div class="mb-5">

                <h2 class="text-lg font-semibold text-slate-900">
                    Lupa Password
                </h2>

                <p class="text-xs text-slate-500 mt-1 leading-5">
                    Masukkan email yang terdaftar. Kami akan
                    mengirimkan link untuk mengatur ulang password Anda.
                </p>

            </div>


            {{-- STATUS --}}
            @if (session('status'))

                <div class="mb-4 rounded-lg bg-green-50
                            border border-green-200
                            px-4 py-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>

            @endif


            {{-- ERROR --}}
            @if ($errors->any())

                <div class="mb-4 rounded-lg bg-red-50
                            border border-red-200
                            px-4 py-3 text-sm text-red-700">
                    Email yang Anda masukkan tidak ditemukan.
                </div>

            @endif


            {{-- FORM --}}
            <form method="POST" action="{{ route('password.email') }}">

                @csrf

                {{-- EMAIL --}}
                <div class="mb-4">

                    <label
                        for="email"
                        class="block text-xs font-semibold text-slate-700 mb-2"
                    >
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
                        class="w-full rounded-lg border border-slate-300
                               px-3 py-2.5 text-sm
                               focus:border-blue-500
                               focus:ring-2 focus:ring-blue-200
                               outline-none transition"
                    >

                    @error('email')

                        <span class="block mt-1 text-xs text-red-600">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="w-full rounded-lg
                           bg-blue-600 hover:bg-blue-700
                           text-white text-sm font-semibold
                           py-2.5 transition"
                >
                    KIRIM LINK RESET PASSWORD
                </button>

            </form>


            {{-- BACK TO LOGIN --}}
            <div class="mt-4 pt-4 border-t border-slate-200 text-center">

                <p class="text-xs text-slate-500">
                    Sudah ingat password?
                </p>

                <a
                    href="{{ route('login') }}"
                    class="inline-block mt-1 text-xs
                           font-semibold text-blue-600
                           hover:text-blue-700"
                >
                    ← Kembali ke Login
                </a>

            </div>

        </div>


        {{-- FOOTER --}}
        <div class="text-center mt-3">

            <p class="text-[10px] text-slate-400">
                © {{ date('Y') }} PT Solusi Bangun Andalas
            </p>

        </div>

    </div>

</body>

</html>