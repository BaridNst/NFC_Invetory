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
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">No</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Peminjam & Barang</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">NFC UID</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Status</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Tgl Pinjam</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Tgl Harus Kembali</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Tgl Kembali</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Status Peminjaman</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Menit Terlambat</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest">Denda</th>
                        <th class="px-4 py-4 text-xs font-bold text-orange-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="">
                    @forelse($items as $index => $item)
                    <tr class="bg-white hover:bg-orange-50/50 transition-all duration-300 group rounded-2xl shadow-sm border border-gray-50 hover:shadow-md hover:shadow-orange-100/50">
                        <td class="px-4 py-5 text-gray-500 font-medium rounded-l-2xl border-y border-l border-transparent group-hover:border-orange-100">{{ $index + 1 }}</td>
                        <td class="px-4 py-5 border-y border-transparent group-hover:border-orange-100">
                            @if($item->status_barang !== 'tersedia' && $item->latestPeminjaman && $item->latestPeminjaman->user)
                                <div class="font-bold text-gray-900 text-sm">{{ $item->latestPeminjaman->user->nama }}</div>
                            @else
                                <div class="text-gray-400 text-xs font-semibold">-</div>
                            @endif
                            <div class="text-xs text-orange-600 font-semibold mt-0.5">{{ $item->nama_barang }}</div>
                        </td>
                        <td class="px-4 py-5 border-y border-transparent group-hover:border-orange-100">
                            <span class="font-mono text-xs bg-gray-50 border border-gray-200 text-gray-600 px-3 py-1.5 rounded-lg shadow-sm">{{ $item->nfc_uid }}</span>
                        </td>
                        <td class="px-4 py-5 border-y border-transparent group-hover:border-orange-100">
                            @if($item->status_barang === 'tersedia')
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-50 border border-emerald-100 text-emerald-600 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Tersedia
                                </span>
                            @elseif($item->status_barang === 'pending_pinjam')
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-50 border border-blue-100 text-blue-600 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                                    Pending Pinjam
                                </span>
                            @elseif($item->status_barang === 'pending_kembali')
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-bold bg-purple-50 border border-purple-100 text-purple-600 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></span>
                                    Pending Kembali
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl text-xs font-bold bg-orange-50 border border-orange-200 text-orange-600 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                    Dipinjam
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-5 text-sm text-gray-900 font-medium border-y border-transparent group-hover:border-orange-100">
                            {{ $item->status_barang !== 'tersedia' && $item->latestPeminjaman && $item->latestPeminjaman->tgl_pinjam ? \Carbon\Carbon::parse($item->latestPeminjaman->tgl_pinjam)->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-4 py-5 text-sm text-gray-955 font-semibold border-y border-transparent group-hover:border-orange-100">
                            {{ $item->status_barang !== 'tersedia' && $item->latestPeminjaman && $item->latestPeminjaman->tgl_harus_kembali ? \Carbon\Carbon::parse($item->latestPeminjaman->tgl_harus_kembali)->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-4 py-5 text-sm text-gray-500 font-medium border-y border-transparent group-hover:border-orange-100">
                            {{ $item->status_barang !== 'tersedia' && $item->latestPeminjaman && $item->latestPeminjaman->tgl_kembali ? \Carbon\Carbon::parse($item->latestPeminjaman->tgl_kembali)->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-4 py-5 text-sm font-bold border-y border-transparent group-hover:border-orange-100">
                            @if($item->status_barang !== 'tersedia' && $item->latestPeminjaman)
                                @if($item->latestPeminjaman->status === 'dikembalikan')
                                    @if($item->latestPeminjaman->denda > 0)
                                        <span class="text-red-500">Terlambat</span>
                                    @else
                                        <span class="text-emerald-500">Tepat Waktu</span>
                                    @endif
                                @else
                                    @if($item->latestPeminjaman->status_terlambat === 'Terlambat')
                                        <span class="text-red-500 animate-pulse">Terlambat</span>
                                    @else
                                        <span class="text-blue-500">Tepat Waktu</span>
                                    @endif
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-5 text-sm text-gray-900 font-bold border-y border-transparent group-hover:border-orange-100">
                            {{ $item->status_barang !== 'tersedia' && $item->latestPeminjaman ? $item->latestPeminjaman->menit_terlambat : '-' }}
                        </td>
                        <td class="px-4 py-5 text-sm font-black border-y border-transparent group-hover:border-orange-100 {{ $item->status_barang !== 'tersedia' && $item->latestPeminjaman && $item->latestPeminjaman->denda_terhitung > 0 ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $item->status_barang !== 'tersedia' && $item->latestPeminjaman ? 'Rp ' . number_format($item->latestPeminjaman->denda_terhitung, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-4 py-5 text-right rounded-r-2xl border-y border-r border-transparent group-hover:border-orange-100 whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                @if($item->status_barang !== 'tersedia' && $item->latestPeminjaman && in_array($item->latestPeminjaman->status, ['dipinjam', 'pending_kembali']))
                                    @php
                                        $waMessage = "Mohon segera kembalikan barang tersebut ke laboratorium dan jika anda terlambat anda akan terkena sanksi denda. Sekian Terima kasih.";
                                        $waPhone = $item->latestPeminjaman->user->no_wa ?? '';
                                        if (str_starts_with($waPhone, '0')) {
                                            $waPhone = '62' . substr($waPhone, 1);
                                        }
                                    @endphp
                                    @if($waPhone)
                                        <a href="https://api.whatsapp.com/send?phone={{ $waPhone }}&text={{ rawurlencode($waMessage) }}" 
                                           target="_blank"
                                           class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-green-50 text-green-600 border border-green-200 hover:bg-green-500 hover:text-white transition-all shadow-sm btn-modern" title="Kirim WA Pengingat Manual (Gratis)">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs mr-1">No WA kosong</span>
                                    @endif
                                @endif
                                <form action="{{ route('admin.items.delete', $item->id_barang) }}" method="POST" onsubmit="return confirm('Hapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 inline-flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:text-red-500 hover:bg-red-50 hover:shadow-lg hover:shadow-red-500/20 transition-all btn-modern border border-gray-100 hover:border-red-100">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-6 py-16 text-center">
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
