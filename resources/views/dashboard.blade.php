@extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    <div class="p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-7 mb-7 cursor-default">
            <div class="bg-blue-500 p-5 rounded-xl shadow hover:shadow-md transform hover:scale-105 duration-300 transition-all">
                <div class="text-sm text-white font-bold flex items-center gap-2">
                    <span class="material-icons">people</span> Total Pengguna
                </div>
                <div class="text-2xl font-bold text-white mt-2">{{ $users->count() }}</div>
            </div>

            <div class="bg-yellow-500 p-5 rounded-xl shadow hover:shadow-md transform hover:scale-105 duration-300 transition-all">
                <div class="text-sm text-white font-bold flex items-center gap-2">
                    <span class="material-icons">inventory_2</span> Total Unit Barang
                </div>
                <div class="text-2xl font-bold text-white mt-2">{{ $units->count() }}</div>
            </div>

            <div class="bg-green-500 p-5 rounded-xl shadow hover:shadow-md transform hover:scale-105 duration-300 transition-all">
                <div class="text-sm text-white font-bold flex items-center gap-2">
                    <span class="material-icons">assignment</span> Total Peminjaman
                </div>
                <div class="text-2xl font-bold text-white mt-2">{{ $borrowings->count() }}</div>
            </div>

            <div class="bg-red-500 p-5 rounded-xl shadow hover:shadow-md transform hover:scale-105 duration-300 transition-all">
                <div class="text-sm text-white font-bold flex items-center gap-2">
                    <span class="material-icons">assignment_return</span> Total Pengembalian
                </div>
                <div class="text-2xl font-bold text-white mt-2">{{ $returnings->count() }}</div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-xl font-semibold text-black mb-4">Aktivitas Terbaru</h2>
            <p class="text-gray-600">Belum ada data aktivitas terbaru. Tambahkan konten di sini nanti.</p>
        </div>
    </div>
@endsection