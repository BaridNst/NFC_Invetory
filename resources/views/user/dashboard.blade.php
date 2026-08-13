@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="space-y-8 animate-fade-in">
    <header class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Halo, {{ Auth::user()->nama }}!</h1>
            <p class="text-gray-500 mt-1 font-medium">Kelola peminjaman barang Anda dengan mudah dan cepat.</p>
        </div>
        <div class="bg-white border border-orange-100 text-orange-600 px-5 py-2.5 rounded-2xl shadow-lg shadow-orange-100 flex items-center gap-3 w-fit hover:-translate-y-1 transition-transform">
            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-500">
                <i class="fas fa-box"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Pinjaman Aktif</span>
                <span class="font-black text-lg leading-none">{{ $activeLoans }}</span>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Action Card -->
        <div class="md:col-span-1">
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-3xl p-8 text-white shadow-xl shadow-orange-500/30 relative overflow-hidden group btn-modern">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10 mix-blend-overlay"></div>
                <div class="relative z-10">
                    <h3 class="text-3xl font-black mb-3">Pinjam Barang</h3>
                    <p class="text-orange-50 mb-8 font-medium leading-relaxed">Gunakan NFC untuk meminjam atau mengembalikan barang secara instan tanpa ribet.</p>
                    <a href="{{ route('user.tapping') }}" class="inline-flex items-center gap-3 bg-white text-orange-600 px-8 py-4 rounded-2xl font-bold hover:bg-gray-50 transition-all active:scale-[0.95] shadow-lg hover:shadow-xl group-hover:-translate-y-1">
                        <i class="fas fa-fingerprint text-xl text-orange-400"></i>
                        Mulai Tapping
                    </a>
                </div>
                <i class="fas fa-mobile-alt absolute -bottom-8 -right-8 text-[180px] text-white opacity-10 group-hover:rotate-12 group-hover:scale-110 transition-transform duration-500"></i>
            </div>
        </div>

        <!-- History Card -->
        <div class="md:col-span-2 space-y-4">
            <h3 class="font-extrabold text-gray-900 text-lg">Riwayat Peminjaman Saya</h3>
            <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/50 border border-orange-50 overflow-hidden">
                <div class="divide-y divide-gray-50/50">
                    @forelse($history as $log)
                    <div class="p-5 flex justify-between items-center hover:bg-orange-50/30 transition-colors group">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 {{ $log->tgl_kembali ? 'bg-gray-50 text-gray-400 group-hover:bg-gray-100' : 'bg-orange-50 text-orange-500 group-hover:bg-orange-100' }} rounded-2xl flex items-center justify-center text-xl transition-colors">
                                <i class="fas fa-laptop"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 text-lg">{{ $log->barang->nama_barang }}</div>
                                <div class="text-xs text-gray-500 font-medium mt-0.5 flex flex-wrap gap-x-3 gap-y-1">
                                    <span><i class="far fa-calendar-alt mr-1 opacity-70"></i> Pinjam: {{ \Carbon\Carbon::parse($log->tgl_pinjam)->format('d M Y, H:i') }}</span>
                                    @if($log->tgl_harus_kembali)
                                        <span class="font-semibold text-orange-600"><i class="far fa-clock mr-1 opacity-70"></i> Harus Kembali: {{ \Carbon\Carbon::parse($log->tgl_harus_kembali)->format('d M Y, H:i') }}</span>
                                    @endif
                                </div>
                                @if($log->denda_terhitung > 0)
                                    <div class="text-xs font-bold text-red-600 mt-1">
                                        <i class="fas fa-exclamation-triangle animate-pulse"></i> Terlambat {{ $log->menit_terlambat }} Menit (Denda: Rp {{ number_format($log->denda_terhitung, 0, ',', '.') }})
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            @if($log->status === 'dikembalikan')
                                <div class="text-xs font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 shadow-sm px-4 py-1.5 rounded-xl uppercase tracking-widest">Selesai</div>
                                <div class="text-[10px] font-medium text-gray-400 mt-2">Kembali: {{ \Carbon\Carbon::parse($log->tgl_kembali)->format('d M, H:i') }}</div>
                            @elseif($log->status === 'ditolak')
                                <div class="text-xs font-bold text-red-600 bg-red-50 border border-red-100 shadow-sm px-4 py-1.5 rounded-xl uppercase tracking-widest">Ditolak</div>
                            @elseif($log->status === 'pending_pinjam')
                                <div class="text-xs font-bold text-blue-600 bg-blue-50 border border-blue-200 shadow-sm px-4 py-1.5 rounded-xl uppercase tracking-widest flex items-center gap-1.5 justify-end">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                    Pending Pinjam
                                </div>
                            @elseif($log->status === 'pending_kembali')
                                <div class="text-xs font-bold text-purple-600 bg-purple-50 border border-purple-200 shadow-sm px-4 py-1.5 rounded-xl uppercase tracking-widest flex items-center gap-1.5 justify-end">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span>
                                    Pending Kembali
                                </div>
                            @else
                                <div class="text-xs font-bold text-orange-600 bg-orange-50 border border-orange-200 shadow-sm px-4 py-1.5 rounded-xl uppercase tracking-widest flex items-center gap-1.5 justify-end">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                                    Dipinjam
                                </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="p-12 text-center text-gray-400">
                        <i class="fas fa-history text-4xl mb-4 block opacity-20"></i>
                        Anda belum pernah meminjam barang.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Item Status Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
        <!-- Barang Tersedia -->
        <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/50 border border-orange-50 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-50 bg-emerald-50/50 flex justify-between items-center">
                <h3 class="font-extrabold text-emerald-700 flex items-center gap-2">
                    <i class="fas fa-check-circle text-emerald-500"></i> Barang Ready
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
                        <div class="text-sm text-gray-400 font-medium italic w-full text-center py-6">Tidak ada barang ready.</div>
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
