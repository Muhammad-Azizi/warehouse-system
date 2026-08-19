@extends('layouts.warehouse')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-2xl font-bold text-slate-900">
                Manajemen User
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Pengelolaan pengguna sistem warehouse
            </p>

        </div>


        {{-- TAMBAH USER --}}
        <a
            href="{{ route('users.create') }}"
            class="inline-flex items-center gap-2
                   px-5 py-3
                   bg-blue-600 text-white
                   rounded-lg
                   font-semibold
                   hover:bg-blue-700
                   transition"
        >

            <span class="text-lg">
                +
            </span>

            Tambah User

        </a>

    </div>


    {{-- PESAN SUCCESS --}}
    @if(session('success'))

        <div
            class="bg-green-50
                   border border-green-200
                   text-green-700
                   rounded-lg
                   px-5 py-4"
        >

            {{ session('success') }}

        </div>

    @endif


    {{-- PESAN ERROR --}}
    @if(session('error'))

        <div
            class="bg-red-50
                   border border-red-200
                   text-red-700
                   rounded-lg
                   px-5 py-4"
        >

            {{ session('error') }}

        </div>

    @endif


    {{-- TABEL USER --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <div class="px-6 py-5 border-b">

            <h2 class="text-lg font-bold text-slate-900">
                Daftar User
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Daftar pengguna yang terdaftar dalam sistem
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50 border-b">

                    <tr>

                        <th class="px-6 py-4 text-left">
                            No
                        </th>

                        <th class="px-6 py-4 text-left">
                            Nama
                        </th>

                        <th class="px-6 py-4 text-left">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left">
                            Terdaftar
                        </th>

                        <th class="px-6 py-4 text-center">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($users as $user)

                        <tr class="hover:bg-gray-50">

                            {{-- NO --}}
                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>


                            {{-- NAMA --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="w-10 h-10
                                               rounded-full
                                               bg-blue-600
                                               text-white
                                               flex items-center
                                               justify-center
                                               font-bold"
                                    >

                                        {{ strtoupper(
                                            substr($user->name, 0, 1)
                                        ) }}

                                    </div>


                                    <div>

                                        <p class="font-semibold text-gray-800">
                                            {{ $user->name }}
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            User
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- EMAIL --}}
                            <td class="px-6 py-4">

                                {{ $user->email }}

                            </td>


                            {{-- TANGGAL --}}
                            <td class="px-6 py-4">

                                {{ $user->created_at?->format('d-m-Y H:i') }}

                            </td>


                            {{-- ACTION --}}
                            <td class="px-6 py-4 text-center">

                                <div class="flex justify-center gap-2">


                                    {{-- DETAIL --}}
                                    <a
                                        href="{{ route('users.show', $user) }}"
                                        class="px-4 py-2
                                               bg-blue-100
                                               text-blue-700
                                               rounded-lg
                                               hover:bg-blue-200
                                               transition"
                                    >

                                        Lihat

                                    </a>


                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('users.edit', $user) }}"
                                        class="px-4 py-2
                                               bg-yellow-100
                                               text-yellow-700
                                               rounded-lg
                                               hover:bg-yellow-200
                                               transition"
                                    >

                                        Edit

                                    </a>


                                    {{-- HAPUS --}}
                                    <form
                                        action="{{ route('users.destroy', $user) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="px-4 py-2
                                                   bg-red-100
                                                   text-red-700
                                                   rounded-lg
                                                   hover:bg-red-200
                                                   transition"
                                        >

                                            Hapus

                                        </button>

                                    </form>


                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-10
                                       text-center
                                       text-gray-500"
                            >

                                Belum ada user.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection