@extends('layouts.app')

@section('title', 'Manajemen Barang')

@section('content')
<div class="space-y-8 animate-fade-in">
    <div class="mb-2">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-orange-600 font-bold hover:gap-3 hover:text-orange-700 transition-all w-fit group">
            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </div>
            Kembali ke Dashboard
        </a>
    </div>
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Manajemen Barang</h1>
            <p class="text-gray-500 mt-1 font-medium">Kelola daftar inventaris dan status ketersediaan dengan mudah.</p>
        </div>
        <a href="{{ route('admin.items.create') }}" class="bg-gradient-to-r from-orange-500 to-orange-400 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-orange-500/30 btn-modern flex items-center gap-2 w-fit">
            <i class="fas fa-plus"></i>
            Tambah Barang Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/50 border border-orange-50 overflow-hidden">
        <div class="overflow-x-auto p-2">
            <table class="w-full text-left border-separate border-spacing-y-2">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">No</th>
                        <th class="px-6 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Nama Barang</th>
                        <th class="px-6 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">NFC UID</th>
                        <th class="px-6 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="">
                    @forelse($items as $index => $item)
                    <tr class="bg-white hover:bg-orange-50/50 transition-all duration-300 group rounded-2xl shadow-sm border border-gray-50 hover:shadow-md hover:shadow-orange-100/50">
                        <td class="px-6 py-5 text-gray-500 font-medium rounded-l-2xl border-y border-l border-transparent group-hover:border-orange-100">{{ $index + 1 }}</td>
                        <td class="px-6 py-5 font-bold text-gray-900 text-lg border-y border-transparent group-hover:border-orange-100">{{ $item->nama_barang }}</td>
                        <td class="px-6 py-5 border-y border-transparent group-hover:border-orange-100">
                            <span class="font-mono text-xs bg-gray-50 border border-gray-200 text-gray-600 px-3 py-1.5 rounded-lg shadow-sm">{{ $item->nfc_uid }}</span>
                        </td>
                        <td class="px-6 py-5 border-y border-transparent group-hover:border-orange-100">
                            @if($item->status_barang === 'tersedia')
                                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl text-xs font-bold bg-emerald-50 border border-emerald-100 text-emerald-600 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl text-xs font-bold bg-orange-50 border border-orange-200 text-orange-600 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                    Dipinjam
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right rounded-r-2xl border-y border-r border-transparent group-hover:border-orange-100">
                            <form action="{{ route('admin.items.delete', $item->id_barang) }}" method="POST" onsubmit="return confirm('Hapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 inline-flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:text-red-500 hover:bg-red-50 hover:shadow-lg hover:shadow-red-500/20 transition-all btn-modern border border-gray-100 hover:border-red-100">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-orange-50 text-orange-300 mb-4 shadow-inner">
                                <i class="fas fa-box-open text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Data</h3>
                            <p class="text-gray-500 font-medium">Tambahkan barang baru untuk mulai mengelola inventaris.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
