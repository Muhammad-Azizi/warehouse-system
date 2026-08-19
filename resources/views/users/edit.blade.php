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
            Edit User
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Perbarui data pengguna
        </p>
    </div>


    @if($errors->any())

        <div class="bg-red-50 border border-red-200 rounded-lg p-5 text-red-700">

            <ul class="list-disc pl-5 space-y-1">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="bg-white rounded-xl shadow-sm border p-6">

        <form
            method="POST"
            action="{{ route('users.update', $user) }}"
            class="space-y-5"
        >

            @csrf

            @method('PUT')


            {{-- NAMA --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    class="w-full rounded-lg border-gray-300
                           focus:border-blue-500
                           focus:ring-blue-500"
                >

            </div>


            {{-- EMAIL --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    class="w-full rounded-lg border-gray-300
                           focus:border-blue-500
                           focus:ring-blue-500"
                >

            </div>


            {{-- PASSWORD BARU --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password"
                    class="w-full rounded-lg border-gray-300
                           focus:border-blue-500
                           focus:ring-blue-500"
                    placeholder="Kosongkan jika tidak ingin mengganti"
                >

            </div>


            {{-- KONFIRMASI PASSWORD --}}
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Konfirmasi Password Baru
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full rounded-lg border-gray-300
                           focus:border-blue-500
                           focus:ring-blue-500"
                    placeholder="Ulangi password baru"
                >

            </div>


            {{-- BUTTON --}}
            <div class="flex justify-end gap-3 pt-4">

                <a
                    href="{{ route('users.index') }}"
                    class="px-5 py-3 bg-gray-200 text-gray-700
                           rounded-lg font-semibold
                           hover:bg-gray-300 transition"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="px-5 py-3 bg-blue-600 text-white
                           rounded-lg font-semibold
                           hover:bg-blue-700 transition"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection