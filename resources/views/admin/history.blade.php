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
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Peminjam & Barang</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Tgl Pinjam</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Tgl Harus Kembali</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Tgl Kembali</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Status Terlambat</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Menit Terlambat</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Denda</th>
                    </tr>
                </thead>
                <tbody class="">
                    @forelse($history as $log)
                    <tr class="bg-white hover:bg-orange-50/50 transition-all duration-300 group rounded-2xl shadow-sm border border-gray-50 hover:shadow-md hover:shadow-orange-100/50">
                        <td class="px-4 py-5 rounded-l-2xl border-y border-l border-transparent group-hover:border-orange-100">
                            <div class="font-bold text-gray-900 text-sm">{{ $log->user->nama }}</div>
                            <div class="text-xs text-orange-600 font-semibold mt-0.5">{{ $log->barang->nama_barang }}</div>
                        </td>
                        <td class="px-4 py-5 text-sm text-gray-900 font-medium border-y border-transparent group-hover:border-orange-100">
                            {{ $log->tgl_pinjam ? \Carbon\Carbon::parse($log->tgl_pinjam)->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-4 py-5 text-sm text-gray-955 font-semibold border-y border-transparent group-hover:border-orange-100">
                            {{ $log->tgl_harus_kembali ? \Carbon\Carbon::parse($log->tgl_harus_kembali)->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-4 py-5 text-sm text-gray-500 font-medium border-y border-transparent group-hover:border-orange-100">
                            {{ $log->tgl_kembali ? \Carbon\Carbon::parse($log->tgl_kembali)->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-4 py-5 text-sm font-bold border-y border-transparent group-hover:border-orange-100">
                            @if($log->status === 'dikembalikan')
                                @if($log->denda > 0)
                                    <span class="text-red-500">Terlambat</span>
                                @else
                                    <span class="text-emerald-500">Tepat Waktu</span>
                                @endif
                            @else
                                @if($log->status_terlambat === 'Terlambat')
                                    <span class="text-red-500 animate-pulse">Terlambat</span>
                                @else
                                    <span class="text-blue-500">Tepat Waktu</span>
                                @endif
                            @endif
                        </td>
                        <td class="px-4 py-5 text-sm text-gray-900 font-bold border-y border-transparent group-hover:border-orange-100">
                            {{ $log->menit_terlambat }}
                        </td>
                        <td class="px-4 py-5 rounded-r-2xl border-y border-r border-transparent group-hover:border-orange-100 text-sm font-black {{ $log->denda_terhitung > 0 ? 'text-red-600' : 'text-gray-900' }}">
                            Rp {{ number_format($log->denda_terhitung, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
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
