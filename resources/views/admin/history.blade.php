@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

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
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Riwayat Transaksi</h1>
            <p class="text-gray-500 mt-1 font-medium">Log seluruh aktivitas peminjaman dan pengembalian barang.</p>
        </div>
        <a href="{{ route('admin.report') }}" target="_blank" class="bg-white text-orange-600 font-bold py-3 px-6 rounded-2xl border border-orange-200 hover:bg-orange-50 hover:border-orange-300 shadow-sm transition-all flex items-center gap-2 btn-modern w-fit">
            <i class="fas fa-print"></i>
            Cetak Laporan PDF
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/50 border border-orange-50 overflow-hidden">
        <div class="overflow-x-auto p-2">
            <table class="w-full text-left border-separate border-spacing-y-2">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Nama Peminjam</th>
                        <th class="px-6 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Barang</th>
                        <th class="px-6 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Tgl Kembali</th>
                        <th class="px-6 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Status</th>
                    </tr>
                </thead>
                <tbody class="">
                    @forelse($history as $log)
                    <tr class="bg-white hover:bg-orange-50/50 transition-all duration-300 group rounded-2xl shadow-sm border border-gray-50 hover:shadow-md hover:shadow-orange-100/50">
                        <td class="px-6 py-5 text-sm text-gray-900 font-medium rounded-l-2xl border-y border-l border-transparent group-hover:border-orange-100">
                            {{ \Carbon\Carbon::parse($log->tgl_pinjam)->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-5 border-y border-transparent group-hover:border-orange-100">
                            <div class="font-bold text-gray-900 text-base">{{ $log->user->nama }}</div>
                            <div class="text-xs text-orange-400 font-medium">@ {{ $log->user->username }}</div>
                        </td>
                        <td class="px-6 py-5 border-y border-transparent group-hover:border-orange-100">
                            <div class="font-bold text-orange-600 text-base">{{ $log->barang->nama_barang }}</div>
                            <div class="text-xs text-gray-400 font-mono bg-gray-50 inline-block px-2 py-0.5 rounded-md mt-1 border border-gray-100">{{ $log->barang->nfc_uid }}</div>
                        </td>
                        <td class="px-6 py-5 text-sm text-gray-500 font-medium border-y border-transparent group-hover:border-orange-100">
                            {{ $log->tgl_kembali ? \Carbon\Carbon::parse($log->tgl_kembali)->format('d M Y, H:i') : '-' }}
                        </td>
                        <td class="px-6 py-5 rounded-r-2xl border-y border-r border-transparent group-hover:border-orange-100">
                            @if(!$log->tgl_kembali)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-orange-50 text-orange-600 border border-orange-100 shadow-sm uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                    Dipinjam
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm uppercase tracking-widest">
                                    <i class="fas fa-check text-emerald-500"></i>
                                    Selesai
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-orange-50 text-orange-300 mb-4 shadow-inner">
                                <i class="fas fa-history text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Transaksi</h3>
                            <p class="text-gray-500 font-medium">Riwayat peminjaman barang akan muncul di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
