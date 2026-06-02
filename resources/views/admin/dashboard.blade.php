@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-8 animate-fade-in">
    <header class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Dashboard Admin</h1>
            <p class="text-gray-500 mt-1 font-medium">Statistik real-time dan kendali penuh inventaris Anda.</p>
        </div>
    </header>

    <div class="bg-white md:bg-transparent rounded-3xl md:rounded-none shadow-lg shadow-orange-100/50 md:shadow-none border border-orange-50 md:border-none p-3 md:p-0">
        <div class="grid grid-cols-4 md:grid-cols-2 lg:grid-cols-4 gap-1 sm:gap-2 md:gap-6">
            <!-- Stat Card 1 -->
            <div class="md:bg-white py-2 px-1 md:p-6 md:rounded-3xl md:shadow-lg md:shadow-orange-100/50 md:border md:border-orange-50 flex flex-col md:flex-row items-center gap-1.5 md:gap-5 hover:bg-orange-50/50 md:hover:bg-white rounded-2xl md:hover:-translate-y-1 transition-all duration-300 text-center md:text-left">
                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-16 md:h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg md:rounded-2xl flex items-center justify-center text-white text-xs md:text-2xl shadow-sm md:shadow-md md:shadow-orange-500/30 shrink-0">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="flex flex-col items-center md:items-start w-full">
                    <div class="text-[7px] sm:text-[9px] md:text-xs text-gray-400 font-extrabold uppercase tracking-widest leading-tight mb-0.5 md:mb-0"><span class="md:hidden">Total BARANG</span><span class="hidden md:inline">Total Barang</span></div>
                    <div class="text-sm sm:text-base md:text-3xl font-black text-gray-900 md:mt-1 leading-none">{{ $totalBarang }}</div>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="md:bg-white py-2 px-1 md:p-6 md:rounded-3xl md:shadow-lg md:shadow-emerald-100/50 md:border md:border-emerald-50 flex flex-col md:flex-row items-center gap-1.5 md:gap-5 hover:bg-emerald-50/50 md:hover:bg-white rounded-2xl md:hover:-translate-y-1 transition-all duration-300 text-center md:text-left">
                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-16 md:h-16 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-lg md:rounded-2xl flex items-center justify-center text-white text-xs md:text-2xl shadow-sm md:shadow-md md:shadow-emerald-500/30 shrink-0">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="flex flex-col items-center md:items-start w-full">
                    <div class="text-[7px] sm:text-[9px] md:text-xs text-gray-400 font-extrabold uppercase tracking-widest leading-tight mb-0.5 md:mb-0"><span class="md:hidden">Sedia</span><span class="hidden md:inline">Tersedia</span></div>
                    <div class="text-sm sm:text-base md:text-3xl font-black text-gray-900 md:mt-1 leading-none">{{ $tersedia }}</div>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="md:bg-white py-2 px-1 md:p-6 md:rounded-3xl md:shadow-lg md:shadow-red-100/50 md:border md:border-red-50 flex flex-col md:flex-row items-center gap-1.5 md:gap-5 hover:bg-red-50/50 md:hover:bg-white rounded-2xl md:hover:-translate-y-1 transition-all duration-300 text-center md:text-left">
                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-16 md:h-16 bg-gradient-to-br from-red-400 to-red-600 rounded-lg md:rounded-2xl flex items-center justify-center text-white text-xs md:text-2xl shadow-sm md:shadow-md md:shadow-red-500/30 shrink-0">
                    <i class="fas fa-hand-holding"></i>
                </div>
                <div class="flex flex-col items-center md:items-start w-full">
                    <div class="text-[7px] sm:text-[9px] md:text-xs text-gray-400 font-extrabold uppercase tracking-widest leading-tight mb-0.5 md:mb-0"><span class="md:hidden">Pinjam</span><span class="hidden md:inline">Dipinjam</span></div>
                    <div class="text-sm sm:text-base md:text-3xl font-black text-gray-900 md:mt-1 leading-none">{{ $dipinjam }}</div>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="md:bg-white py-2 px-1 md:p-6 md:rounded-3xl md:shadow-lg md:shadow-amber-100/50 md:border md:border-amber-50 flex flex-col md:flex-row items-center gap-1.5 md:gap-5 hover:bg-amber-50/50 md:hover:bg-white rounded-2xl md:hover:-translate-y-1 transition-all duration-300 text-center md:text-left">
                <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-16 md:h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-lg md:rounded-2xl flex items-center justify-center text-white text-xs md:text-2xl shadow-sm md:shadow-md md:shadow-amber-500/30 shrink-0">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="flex flex-col items-center md:items-start w-full">
                    <div class="text-[7px] sm:text-[9px] md:text-xs text-gray-400 font-extrabold uppercase tracking-widest leading-tight mb-0.5 md:mb-0"><span class="md:hidden">TRANSAKSI</span><span class="hidden md:inline">Total Transaksi</span></div>
                    <div class="text-sm sm:text-base md:text-3xl font-black text-gray-900 md:mt-1 leading-none">{{ $transaksi }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/50 border border-orange-50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-extrabold text-gray-900 text-lg">Aksi Cepat</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <a href="{{ route('admin.items') }}" class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-4 p-5 rounded-2xl bg-white hover:bg-orange-50 hover:text-orange-600 transition-all border border-gray-100 hover:border-orange-200 shadow-sm hover:shadow-md hover:shadow-orange-100 group btn-modern">
                        <div class="w-14 h-14 shrink-0 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center shadow-sm group-hover:bg-gradient-to-r group-hover:from-orange-500 group-hover:to-orange-400 group-hover:text-white transition-all duration-300 text-xl">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div> 
                            <div class="font-bold text-gray-800 group-hover:text-orange-600 transition-colors">Manajemen Barang</div>
                            <div class="text-xs text-gray-400 mt-1 font-medium">Daftar inventaris & status</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.items.create') }}" class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-4 p-5 rounded-2xl bg-white hover:bg-orange-50 hover:text-orange-600 transition-all border border-gray-100 hover:border-orange-200 shadow-sm hover:shadow-md hover:shadow-orange-100 group btn-modern">
                        <div class="w-14 h-14 shrink-0 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center shadow-sm group-hover:bg-gradient-to-r group-hover:from-orange-500 group-hover:to-orange-400 group-hover:text-white transition-all duration-300 text-xl">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div>
                            <div class="font-bold text-gray-800 group-hover:text-orange-600 transition-colors">Tambah Barang</div>
                            <div class="text-xs text-gray-400 mt-1 font-medium">Daftarkan tag NFC baru</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.history') }}" class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-4 p-5 rounded-2xl bg-white hover:bg-orange-50 hover:text-orange-600 transition-all border border-gray-100 hover:border-orange-200 shadow-sm hover:shadow-md hover:shadow-orange-100 group btn-modern">
                        <div class="w-14 h-14 shrink-0 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center shadow-sm group-hover:bg-gradient-to-r group-hover:from-orange-500 group-hover:to-orange-400 group-hover:text-white transition-all duration-300 text-xl">
                            <i class="fas fa-history"></i>
                        </div>
                        <div>
                            <div class="font-bold text-gray-800 group-hover:text-orange-600 transition-colors">Riwayat Transaksi</div>
                            <div class="text-xs text-gray-400 mt-1 font-medium">Lihat semua log aktivitas</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-orange-500/30 btn-modern group">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10 mix-blend-overlay"></div>
            <div class="relative z-10">
                <h3 class="text-2xl font-black mb-3">Export Laporan</h3>
                <p class="text-orange-100 mb-8 leading-relaxed font-medium">Download riwayat transaksi lengkap dalam format PDF untuk keperluan dokumentasi.</p>
                <a href="{{ route('admin.report') }}" target="_blank" class="inline-flex items-center gap-2 bg-white text-orange-600 px-6 py-3.5 rounded-xl font-bold shadow-lg hover:bg-gray-50 hover:scale-105 transition-all">
                    <i class="fas fa-file-pdf text-red-500"></i>
                    Generate PDF
                </a>
            </div>
            <i class="fas fa-file-alt absolute -bottom-4 -right-4 text-9xl text-white opacity-10 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-500"></i>
        </div>
    </div>

    <!-- Pending Requests Section -->
    <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/50 border border-orange-50 overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-gray-50 bg-orange-50/50 flex justify-between items-center">
            <h3 class="font-extrabold text-orange-700 flex items-center gap-2">
                <i class="fas fa-bell text-orange-500"></i> Menunggu Konfirmasi
            </h3>
            @if($pendingRequests->count() > 0)
                <span class="bg-orange-500 text-white shadow-sm shadow-orange-500/30 text-xs font-black px-2.5 py-1 rounded-lg animate-pulse">{{ $pendingRequests->count() }} Request</span>
            @endif
        </div>
        <div class="p-0">
            @if($pendingRequests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-bold">
                                <th class="p-4 pl-6">Peminjam</th>
                                <th class="p-4">Barang</th>
                                <th class="p-4">Tipe Request</th>
                                <th class="p-4">Waktu</th>
                                <th class="p-4 pr-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($pendingRequests as $req)
                                <tr class="hover:bg-orange-50/30 transition-colors">
                                    <td class="p-4 pl-6 font-bold text-gray-800">{{ $req->user->nama }}</td>
                                    <td class="p-4 text-gray-600 font-medium">{{ $req->barang->nama_barang }}</td>
                                    <td class="p-4">
                                        @if($req->status === 'pending_pinjam')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 text-blue-600 text-xs font-bold border border-blue-100">
                                                <i class="fas fa-arrow-right"></i> Pinjam
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-purple-50 text-purple-600 text-xs font-bold border border-purple-100">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-400 font-medium">{{ \Carbon\Carbon::parse($req->status === 'pending_pinjam' ? $req->tgl_pinjam : $req->updated_at)->diffForHumans() }}</td>
                                    <td class="p-4 pr-6">
                                        <div class="flex justify-end gap-2">
                                            <form action="{{ route('admin.peminjaman.approve', $req->id_peminjaman) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all flex items-center justify-center shadow-sm" title="Setujui">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.peminjaman.reject', $req->id_peminjaman) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center shadow-sm" title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center text-gray-400 font-medium flex flex-col items-center gap-3">
                    <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center text-gray-300 text-2xl mb-2">
                        <i class="fas fa-inbox"></i>
                    </div>
                    Tidak ada request yang menunggu konfirmasi saat ini.
                </div>
            @endif
        </div>
    </div>

    <!-- Item Status Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Barang Tersedia -->
        <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/50 border border-orange-50 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 bg-emerald-50/50 flex justify-between items-center">
                <h3 class="font-extrabold text-emerald-700 flex items-center gap-2">
                    <i class="fas fa-check-circle text-emerald-500"></i> Barang Tersedia
                </h3>
                <span class="bg-emerald-500 text-white shadow-sm shadow-emerald-500/30 text-xs font-black px-2.5 py-1 rounded-lg">{{ $listTersedia->count() }}</span>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap gap-2">
                    @forelse($listTersedia as $barang)
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-emerald-700 text-sm font-bold border border-emerald-100 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-emerald-300 cursor-default">
                            <i class="fas fa-cube text-emerald-400"></i>
                            {{ $barang->nama_barang }}
                        </span>
                    @empty
                        <div class="text-sm text-gray-400 font-medium italic w-full text-center py-6">Tidak ada barang tersedia.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Barang Dipinjam -->
        <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/50 border border-orange-50 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 bg-red-50/50 flex justify-between items-center">
                <h3 class="font-extrabold text-red-700 flex items-center gap-2">
                    <i class="fas fa-hand-holding text-red-500"></i> Sedang Dipinjam
                </h3>
                <span class="bg-red-500 text-white shadow-sm shadow-red-500/30 text-xs font-black px-2.5 py-1 rounded-lg">{{ $listDipinjam->count() }}</span>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap gap-2">
                    @forelse($listDipinjam as $barang)
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-red-700 text-sm font-bold border border-red-100 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-md hover:border-red-300 cursor-default">
                            <i class="fas fa-cube text-red-400"></i>
                            {{ $barang->nama_barang }}
                        </span>
                    @empty
                        <div class="text-sm text-gray-400 font-medium italic w-full text-center py-6">Tidak ada barang yang sedang dipinjam.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
