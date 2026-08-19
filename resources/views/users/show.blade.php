@extends('layouts.warehouse')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

    <div>

        <a
            href="{{ route('users.index') }}"
            class="text-blue-600 hover:underline"
        >
            ← Kembali ke User
        </a>

        <h1 class="text-2xl font-bold text-slate-900 mt-3">
            Detail User
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Informasi pengguna sistem warehouse
        </p>

    </div>


    <div class="bg-white rounded-xl shadow-sm border p-6">

        <div class="flex items-center gap-5 pb-6 border-b">

            <div
                class="w-16 h-16 rounded-full
                       bg-blue-600 text-white
                       flex items-center justify-center
                       text-2xl font-bold"
            >
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>


            <div>

                <h2 class="text-xl font-bold text-gray-800">
                    {{ $user->name }}
                </h2>

                <p class="text-gray-500">
                    {{ $user->email }}
                </p>

            </div>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

            {{-- NAMA --}}
            <div>

                <p class="text-sm text-gray-500">
                    Nama
                </p>

                <p class="font-semibold text-gray-800 mt-1">
                    {{ $user->name }}
                </p>

            </div>


            {{-- EMAIL --}}
            <div>

                <p class="text-sm text-gray-500">
                    Email
                </p>

                <p class="font-semibold text-gray-800 mt-1">
                    {{ $user->email }}
                </p>

            </div>


            {{-- DIBUAT --}}
            <div>

                <p class="text-sm text-gray-500">
                    Terdaftar
                </p>

                <p class="font-semibold text-gray-800 mt-1">
                    {{ $user->created_at?->format('d-m-Y H:i') }}
                </p>

            </div>


            {{-- DIPERBARUI --}}
            <div>

                <p class="text-sm text-gray-500">
                    Terakhir Diperbarui
                </p>

                <p class="font-semibold text-gray-800 mt-1">
                    {{ $user->updated_at?->format('d-m-Y H:i') }}
                </p>

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 mt-8 pt-6 border-t">

            <a
                href="{{ route('users.index') }}"
                class="px-5 py-3 bg-gray-200 text-gray-700
                       rounded-lg font-semibold
                       hover:bg-gray-300 transition"
            >
                Kembali
            </a>


            <a
                href="{{ route('users.edit', $user) }}"
                class="px-5 py-3 bg-yellow-500 text-white
                       rounded-lg font-semibold
                       hover:bg-yellow-600 transition"
            >
                Edit User
            </a>

        </div>

    </div>

</div>

@endsection