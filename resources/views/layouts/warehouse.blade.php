<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{ $title ?? config('app.name', 'Warehouse System') }}
    </title>


    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
        rel="stylesheet"
    />


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="font-sans antialiased bg-gray-100">


<div class="min-h-screen flex">


    {{-- ====================================================== --}}
    {{-- SIDEBAR --}}
    {{-- ====================================================== --}}

    <aside
        class="relative z-50 w-64 min-h-screen
               bg-slate-900 text-white flex-shrink-0"
    >


        {{-- ================================================== --}}
        {{-- LOGO --}}
        {{-- ================================================== --}}

        <div
            class="flex items-center gap-3 px-6 py-5
                   border-b border-slate-700"
        >

            <div
                class="w-10 h-10 bg-white rounded-lg
                       flex items-center justify-center"
            >

                <span class="text-blue-900 font-bold">
                    SBA
                </span>

            </div>


            <div>

                <h1 class="font-bold text-sm">
                    PT SOLUSI BANGUN
                </h1>

                <p class="text-xs text-slate-300">
                    ANDALAS
                </p>

            </div>

        </div>


        {{-- ================================================== --}}
        {{-- MENU --}}
        {{-- ================================================== --}}

        <nav
            class="relative z-50 px-4 py-6 space-y-2"
        >


            {{-- ================================================= --}}
            {{-- DASHBOARD --}}
            {{-- ================================================= --}}

            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3
                       rounded-lg hover:bg-blue-600
                       transition cursor-pointer
                       {{ request()->routeIs('dashboard')
                            ? 'bg-blue-600'
                            : '' }}"
            >

                <span class="text-lg">
                    🏠
                </span>

                <span>
                    Dashboard
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- MASTER MATERIAL --}}
            {{-- ================================================= --}}

            <a
                href="{{ route('materials.index') }}"
                class="flex items-center gap-3 px-4 py-3
                       rounded-lg hover:bg-blue-600
                       transition cursor-pointer
                       {{ request()->routeIs('materials.*')
                            ? 'bg-blue-600'
                            : '' }}"
            >

                <span class="text-lg">
                    📦
                </span>

                <span>
                    Master Material
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- BARANG MASUK --}}
            {{-- ================================================= --}}

            <a
                href="{{ route('barang-masuk.index') }}"
                class="flex items-center gap-3 px-4 py-3
                       rounded-lg hover:bg-blue-600
                       transition cursor-pointer
                       {{ request()->routeIs('barang-masuk.*')
                            ? 'bg-blue-600'
                            : '' }}"
            >

                <span class="text-lg">
                    📥
                </span>

                <span>
                    Barang Masuk
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- BARANG KELUAR --}}
            {{-- ================================================= --}}

            <a
                href="{{ route('barang-keluar.index') }}"
                class="flex items-center gap-3 px-4 py-3
                       rounded-lg hover:bg-blue-600
                       transition cursor-pointer
                       {{ request()->routeIs('barang-keluar.*')
                            ? 'bg-blue-600'
                            : '' }}"
            >

                <span class="text-lg">
                    📤
                </span>

                <span>
                    Barang Keluar
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- PICKING LIST --}}
            {{-- ================================================= --}}

            <a
                href="{{ route('picking-list.index') }}"
                class="flex items-center gap-3 px-4 py-3
                       rounded-lg hover:bg-blue-600
                       transition cursor-pointer
                       {{ request()->routeIs('picking-list.*')
                            ? 'bg-blue-600'
                            : '' }}"
            >

                <span class="text-lg">
                    📋
                </span>

                <span>
                    Picking List
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- LAPORAN --}}
            {{-- ================================================= --}}

            <a
                href="{{ route('laporan.index') }}"
                class="flex items-center gap-3 px-4 py-3
                       rounded-lg hover:bg-blue-600
                       transition cursor-pointer
                       {{ request()->routeIs('laporan.*')
                            ? 'bg-blue-600'
                            : '' }}"
            >

                <span class="text-lg">
                    📊
                </span>

                <span>
                    Laporan
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- USER --}}
            {{-- ================================================= --}}

            <a
                href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-3
                       rounded-lg hover:bg-blue-600
                       transition cursor-pointer
                       {{ request()->routeIs('users.*')
                            ? 'bg-blue-600'
                            : '' }}"
            >

                <span class="text-lg">
                    👤
                </span>

                <span>
                    User
                </span>

            </a>


        </nav>


        {{-- ================================================== --}}
        {{-- LOGOUT --}}
        {{-- ================================================== --}}

        <div
            class="absolute bottom-5 left-0 w-full px-4"
        >

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="w-full flex items-center gap-3
                           px-4 py-3
                           text-slate-300
                           hover:text-white
                           hover:bg-red-600
                           rounded-lg
                           transition
                           cursor-pointer"
                >

                    <span class="text-lg">
                        🚪
                    </span>

                    <span>
                        Logout
                    </span>

                </button>

            </form>

        </div>


    </aside>


    {{-- ====================================================== --}}
    {{-- MAIN CONTENT --}}
    {{-- ====================================================== --}}

    <main
        class="relative z-10 flex-1 min-w-0"
    >


        {{-- ================================================== --}}
        {{-- TOPBAR --}}
        {{-- ================================================== --}}

        <header
            class="bg-white border-b px-8 py-4
                   flex justify-between items-center"
        >


            {{-- TITLE --}}
            <div>

                <h2 class="text-xl font-bold text-slate-900">

                    {{ $title ?? 'Dashboard' }}

                </h2>


                <p class="text-sm text-gray-500">

                    Sistem Informasi Warehouse

                </p>

            </div>


            {{-- ================================================= --}}
            {{-- USER LOGIN --}}
            {{-- ================================================= --}}

            <div class="flex items-center gap-3">


                <div class="text-right">

                    <p class="font-semibold text-slate-800">

                        {{ Auth::user()->name }}

                    </p>


                    <p class="text-xs text-gray-500">

                        Administrator

                    </p>

                </div>


                <div
                    class="w-10 h-10 rounded-full
                           bg-blue-600 text-white
                           flex items-center justify-center
                           font-bold"
                >

                    {{ strtoupper(
                        substr(Auth::user()->name, 0, 1)
                    ) }}

                </div>


            </div>

        </header>


        {{-- ================================================== --}}
        {{-- CONTENT --}}
        {{-- ================================================== --}}

        <section class="p-8">

            @yield('content')


            @isset($slot)

                {{ $slot }}

            @endisset

        </section>


    </main>


</div>


</body>

</html>