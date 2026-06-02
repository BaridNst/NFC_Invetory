@extends('layouts.app')

@section('title', 'Tapping NFC')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center text-center px-4">
    <div id="status-container" class="w-full max-w-sm">
        <!-- Initial State -->
        <div id="state-idle" class="space-y-8 animate-fade-in">
            <div class="relative mx-auto w-48 h-48 group">
                <div class="absolute inset-0 bg-orange-200 rounded-full animate-ping opacity-30"></div>
                <div class="absolute inset-4 bg-orange-100 rounded-full animate-ping opacity-40" style="animation-delay: 0.3s"></div>
                <div class="relative w-48 h-48 bg-white border border-orange-100 rounded-full flex items-center justify-center text-orange-500 text-6xl shadow-xl shadow-orange-100 group-hover:scale-105 transition-transform duration-500">
                    <i class="fas fa-fingerprint"></i>
                </div>
            </div>
            
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Siap Scan NFC</h2>
                <p class="text-gray-500 mt-3 font-medium">Tempelkan HP Anda pada tag/stiker NFC barang untuk memulai proses peminjaman.</p>
            </div>

            <button onclick="startScanningUser('{{ route('user.process-tap') }}', '{{ route('user.dashboard') }}')" id="btn-start"
                class="w-full bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white font-bold py-4 rounded-2xl shadow-xl shadow-orange-500/30 transition-all btn-modern flex items-center justify-center gap-3 text-lg">
                <i class="fas fa-broadcast-tower animate-pulse"></i>
                Mulai Scan Sekarang
            </button>
            <a href="{{ route('user.dashboard') }}" class="block text-gray-400 font-bold text-sm hover:text-orange-500 transition-colors uppercase tracking-widest">Batal</a>
        </div>

        <!-- Scanning State -->
        <div id="state-scanning" class="hidden space-y-8 animate-fade-in">
            <div class="relative mx-auto w-48 h-48 flex items-center justify-center">
                <div class="absolute inset-0 border-4 border-orange-500 border-t-transparent rounded-full animate-spin"></div>
                <div class="absolute inset-4 border-4 border-orange-200 border-b-transparent rounded-full animate-spin" style="animation-direction: reverse; animation-duration: 1.5s;"></div>
                <div class="w-36 h-36 bg-white rounded-full flex items-center justify-center text-orange-500 text-5xl shadow-lg shadow-orange-100">
                    <i class="fas fa-wifi rotate-90 animate-pulse"></i>
                </div>
            </div>
            
            <div>
                <h2 class="text-3xl font-extrabold text-orange-600 tracking-tight">Mencari Tag...</h2>
                <p class="text-gray-500 mt-3 font-medium animate-pulse">Dekatkan tag ke area sensor NFC di HP Anda</p>
            </div>

            <div class="p-5 bg-orange-50/80 border border-orange-100 rounded-2xl text-xs text-orange-700 flex items-center gap-3 shadow-sm font-medium">
                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-orange-500 shrink-0">
                    <i class="fas fa-info-circle text-lg"></i>
                </div>
                Pastikan fitur NFC di pengaturan HP Anda sudah aktif.
            </div>
        </div>

        <!-- Processing State -->
        <div id="state-processing" class="hidden space-y-8 animate-fade-in">
            <div class="mx-auto w-48 h-48 bg-white border border-gray-100 shadow-xl shadow-gray-100/50 rounded-full flex items-center justify-center text-orange-500 text-6xl">
                <i class="fas fa-circle-notch fa-spin"></i>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Memproses...</h2>
                <p class="text-gray-500 mt-3 font-medium">Menghubungkan ke server untuk memvalidasi data barang.</p>
            </div>
        </div>

        <!-- Result States (Success/Error) will be injected here via JS -->
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/nfc-user.js') }}"></script>
@endpush
@endsection
