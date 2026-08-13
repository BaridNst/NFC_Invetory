@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-8 animate-fade-in">
    <header class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Dashboard Admin</h1>
            <p class="text-gray-500 mt-1 font-medium">Statistik real-time dan kendali penuh alat Laboratorium.</p>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" style="width: 100%; max-width: 100%;">
        <!-- 4 Grid Stats (Kiri) -->
        <div class="lg:col-span-2" style="width: 100%; max-width: 100%;">
            <div class="grid grid-cols-2 gap-4 w-full">
                <!-- Stat Card 1: Total Barang -->
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(249,115,22,0.04)] border border-orange-100/60 flex items-center hover:bg-gradient-to-br hover:from-white hover:to-orange-50/40 hover:-translate-y-1 hover:shadow-[0_15px_35px_rgba(249,115,22,0.08)] transition-all duration-300 p-4 sm:p-5 gap-3 sm:gap-5 group" style="min-w: 0; box-sizing: border-box;">
                    <div class="relative shrink-0">
                        <!-- Glow Aura -->
                        <div class="absolute inset-0 bg-orange-500 rounded-2xl blur-md opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                        <!-- Gradient Icon Box -->
                        <div class="relative w-11 h-11 sm:w-14 sm:h-14 bg-gradient-to-br from-orange-500 to-amber-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7l10 5 10-5-10-5z" fill="rgba(255,255,255,0.15)" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                <path d="M2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2 7v10M12 12v10M22 7v10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-[10px] sm:text-xs text-gray-400 font-extrabold uppercase tracking-widest truncate">Total Barang</span>
                        <span class="text-xl sm:text-3xl font-black text-gray-900 leading-none mt-1 group-hover:text-orange-600 transition-colors">{{ $totalBarang }}</span>
                    </div>
                </div>

                <!-- Stat Card 2: Tersedia -->
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(16,185,129,0.04)] border border-emerald-100/60 flex items-center hover:bg-gradient-to-br hover:from-white hover:to-emerald-50/40 hover:-translate-y-1 hover:shadow-[0_15px_35px_rgba(16,185,129,0.08)] transition-all duration-300 p-4 sm:p-5 gap-3 sm:gap-5 group" style="min-w: 0; box-sizing: border-box;">
                    <div class="relative shrink-0">
                        <!-- Glow Aura -->
                        <div class="absolute inset-0 bg-emerald-500 rounded-2xl blur-md opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                        <!-- Gradient Icon Box -->
                        <div class="relative w-11 h-11 sm:w-14 sm:h-14 bg-gradient-to-br from-emerald-500 to-teal-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="9" fill="rgba(255,255,255,0.15)" stroke="currentColor" stroke-width="2"/>
                                <path d="M8 12l3 3 5-5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-[10px] sm:text-xs text-gray-400 font-extrabold uppercase tracking-widest truncate">Tersedia</span>
                        <span class="text-xl sm:text-3xl font-black text-gray-900 leading-none mt-1 group-hover:text-emerald-600 transition-colors">{{ $tersedia }}</span>
                    </div>
                </div>

                <!-- Stat Card 3: Dipinjam -->
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(239,68,68,0.04)] border border-red-100/60 flex items-center hover:bg-gradient-to-br hover:from-white hover:to-red-50/40 hover:-translate-y-1 hover:shadow-[0_15px_35px_rgba(239,68,68,0.08)] transition-all duration-300 p-4 sm:p-5 gap-3 sm:gap-5 group" style="min-w: 0; box-sizing: border-box;">
                    <div class="relative shrink-0">
                        <!-- Glow Aura -->
                        <div class="absolute inset-0 bg-red-500 rounded-2xl blur-md opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                        <!-- Gradient Icon Box -->
                        <div class="relative w-11 h-11 sm:w-14 sm:h-14 bg-gradient-to-br from-red-500 to-rose-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-red-500/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2v-9a2 2 0 00-2-2h-3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 12V3m0 0L9 6m3-3l3 3" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-[10px] sm:text-xs text-gray-400 font-extrabold uppercase tracking-widest truncate">Dipinjam</span>
                        <span class="text-xl sm:text-3xl font-black text-gray-900 leading-none mt-1 group-hover:text-red-600 transition-colors">{{ $dipinjam }}</span>
                    </div>
                </div>

                <!-- Stat Card 4: Total Transaksi -->
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(245,158,11,0.04)] border border-amber-100/60 flex items-center hover:bg-gradient-to-br hover:from-white hover:to-amber-50/40 hover:-translate-y-1 hover:shadow-[0_15px_35px_rgba(245,158,11,0.08)] transition-all duration-300 p-4 sm:p-5 gap-3 sm:gap-5 group" style="min-w: 0; box-sizing: border-box;">
                    <div class="relative shrink-0">
                        <!-- Glow Aura -->
                        <div class="absolute inset-0 bg-amber-500 rounded-2xl blur-md opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                        <!-- Gradient Icon Box -->
                        <div class="relative w-11 h-11 sm:w-14 sm:h-14 bg-gradient-to-br from-amber-500 to-yellow-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 7h9.172l-2.586 2.586a1 1 0 001.414 1.414l4.3-4.3a1 1 0 000-1.414l-4.3-4.3a1 1 0 00-1.414 1.414L16.172 5H7a3 3 0 00-3 3v7a1 1 0 102 0V8a1 1 0 011-1z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17 17H7.828l2.586-2.586a1 1 0 10-1.414-1.414l-4.3 4.3a1 1 0 000 1.414l4.3 4.3a1 1 0 001.414-1.414L7.828 19H17a3 3 0 003-3V9a1 1 0 10-2 0v7a1 1 0 01-1 1z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-[10px] sm:text-xs text-gray-400 font-extrabold uppercase tracking-widest truncate">Total Transaksi</span>
                        <span class="text-xl sm:text-3xl font-black text-gray-900 leading-none mt-1 group-hover:text-amber-600 transition-colors">{{ $transaksi }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan (Export Laporan & Konfirmasi) -->
        <div class="space-y-6">
            <!-- Export Laporan -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-3xl p-5 text-white relative overflow-hidden shadow-xl shadow-orange-500/30 btn-modern group flex flex-col justify-between">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10 mix-blend-overlay"></div>
                <div class="relative z-10">
                    <h3 class="text-lg font-black mb-1">Export Laporan</h3>
                    <p class="text-orange-100 leading-relaxed font-medium text-xs">Unduh riwayat transaksi format PDF.</p>
                </div>
                <div class="relative z-10 mt-4">
                    <a href="{{ route('admin.report') }}" target="_blank" class="inline-flex items-center gap-2 bg-white text-orange-600 px-4 py-2 rounded-xl font-bold shadow-lg hover:bg-gray-50 hover:scale-105 transition-all w-full justify-center text-xs">
                        <i class="fas fa-file-pdf text-red-500"></i>
                        Generate PDF
                    </a>
                </div>
                <i class="fas fa-file-alt absolute -bottom-4 -right-4 text-7xl text-white opacity-10 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-500"></i>
            </div>

            <!-- Pending Requests Section -->
            <div class="bg-white rounded-3xl shadow-lg shadow-orange-100/50 border border-orange-50 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-50 bg-orange-50/50 flex justify-between items-center">
                    <h3 class="font-extrabold text-orange-700 text-sm flex items-center gap-2">
                        <i class="fas fa-bell text-orange-500"></i> Menunggu Konfirmasi
                    </h3>
                    @if($pendingRequests->count() > 0)
                        <span class="bg-orange-500 text-white text-xs font-black px-2 py-0.5 rounded-lg animate-pulse">{{ $pendingRequests->count() }}</span>
                    @endif
                </div>
                <div class="p-4 divide-y divide-gray-50 max-h-[320px] overflow-y-auto">
                    @forelse($pendingRequests as $req)
                        <div class="py-3 first:pt-0 last:pb-0 space-y-2">
                            <div class="flex justify-between items-start gap-2">
                                <div class="min-w-0">
                                    <div class="font-bold text-gray-800 text-sm truncate">{{ $req->user->nama }}</div>
                                    <div class="text-xs text-gray-500 truncate mt-0.5">{{ $req->barang->nama_barang }}</div>
                                </div>
                                <div class="shrink-0">
                                    @if($req->status === 'pending_pinjam')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-50 text-blue-600 text-[10px] font-bold border border-blue-100">
                                            <i class="fas fa-arrow-right"></i> Pinjam
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-50 text-purple-600 text-[10px] font-bold border border-purple-100">
                                            <i class="fas fa-arrow-left"></i> Kembali
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-between items-center gap-2">
                                <span class="text-[10px] text-gray-400 font-medium">{{ \Carbon\Carbon::parse($req->status === 'pending_pinjam' ? $req->tgl_pinjam : $req->updated_at)->diffForHumans() }}</span>
                                <div class="flex gap-1.5">
                                    @if($req->status === 'pending_pinjam')
                                        <a href="{{ route('admin.approvals') }}" class="h-7 px-2.5 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all flex items-center justify-center text-xs font-bold shadow-sm" title="Buka Menu Persetujuan">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    @else
                                        <form action="{{ route('admin.peminjaman.approve', $req->id_peminjaman) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="h-7 px-2.5 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all flex items-center justify-center text-xs font-bold shadow-sm" title="Setujui Kembali">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.peminjaman.reject', $req->id_peminjaman) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="h-7 px-2.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center text-xs font-bold shadow-sm" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-6 text-center text-gray-400 text-xs font-medium flex flex-col items-center gap-2">
                            <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-300 text-lg">
                                <i class="fas fa-inbox"></i>
                            </div>
                            Tidak ada request konfirmasi.
                        </div>
                    @endforelse
                </div>
            </div>
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
                <span class="bg-red-500 text-white shadow-sm shadow-red-500/30 text-xs font-black px-2.5 py-1 rounded-lg">{{ $activeLoans->count() }}</span>
            </div>
            <div class="p-6">
                <div class="divide-y divide-gray-100 max-h-[300px] overflow-y-auto pr-1">
                    @forelse($activeLoans as $loan)
                        <div class="py-3.5 first:pt-0 last:pb-0 flex items-center justify-between gap-3 group">
                            <div class="min-w-0">
                                <div class="font-bold text-gray-900 text-sm truncate">{{ $loan->barang->nama_barang }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    Peminjam: <span class="font-semibold text-gray-700">{{ $loan->user->nama }}</span>
                                </div>
                                <div class="text-[10px] text-orange-600 font-semibold mt-1 flex items-center gap-1">
                                    <i class="far fa-clock"></i> Batas: {{ $loan->tgl_harus_kembali ? \Carbon\Carbon::parse($loan->tgl_harus_kembali)->format('d/m H:i') : '-' }}
                                </div>
                                @if($loan->denda_terhitung > 0)
                                    <div class="text-[10px] font-bold text-red-600 mt-0.5 animate-pulse">
                                        Denda: Rp {{ number_format($loan->denda_terhitung, 0, ',', '.') }} ({{ $loan->menit_terlambat }}m)
                                    </div>
                                @endif
                            </div>
                            <div class="shrink-0">
                                @php
                                    $waMessage = "Mohon segera kembalikan barang tersebut ke laboratorium dan jika anda terlambat anda akan terkena sanksi denda. Sekian Terima kasih.";
                                    $waPhone = $loan->user->no_wa ?? '';
                                    if (str_starts_with($waPhone, '0')) {
                                        $waPhone = '62' . substr($waPhone, 1);
                                    }
                                @endphp
                                @if($waPhone)
                                    <a href="https://api.whatsapp.com/send?phone={{ $waPhone }}&text={{ rawurlencode($waMessage) }}" 
                                       target="_blank" 
                                       class="px-3 py-1.5 bg-green-50 text-green-600 border border-green-200 hover:bg-green-500 hover:text-white rounded-xl text-xs font-bold shadow-sm transition-all btn-modern flex items-center gap-1"
                                       title="Kirim Pengingat WA Manual (Gratis)">
                                        <i class="fab fa-whatsapp"></i> Pengingat
                                    </a>
                                @else
                                    <span class="text-gray-400 text-[10px] font-semibold">No WA kosong</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-400 font-medium italic w-full text-center py-6">Tidak ada barang yang sedang dipinjam.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
