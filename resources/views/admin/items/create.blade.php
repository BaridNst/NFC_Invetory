@extends('layouts.app')

@section('title', 'Tambah Barang Baru')

@section('content')
<div class="animate-fade-in">
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-orange-600 font-bold hover:gap-3 hover:text-orange-700 transition-all w-fit group">
            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </div>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="mb-8 text-center sm:text-left">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Tambah Barang</h1>
            <p class="text-gray-500 mt-2 font-medium">Daftarkan barang baru ke sistem inventaris menggunakan NFC.</p>
        </div>

    <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/50 border border-orange-50 p-8 sm:p-10 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-orange-400 to-orange-500"></div>
        <form action="{{ route('admin.items.store') }}" method="POST" class="space-y-8 mt-2">
            @csrf
            
            <div class="space-y-4">
                <label class="block text-sm font-extrabold text-gray-800 uppercase tracking-widest">1. Scan NFC Tag</label>
                <div id="nfc-status" class="p-8 border-2 border-dashed border-orange-200 bg-orange-50/50 rounded-3xl text-center transition-all hover:bg-orange-50 hover:border-orange-300">
                    <div id="nfc-idle">
                        <div class="w-20 h-20 bg-white shadow-sm border border-orange-100 rounded-2xl flex items-center justify-center text-orange-400 mx-auto mb-5 relative group-hover:scale-110 transition-transform">
                            <i class="fas fa-wifi text-3xl rotate-90"></i>
                            <div class="absolute -right-2 -top-2 w-6 h-6 bg-orange-100 rounded-full flex items-center justify-center animate-bounce">
                                <i class="fas fa-arrow-down text-xs text-orange-600"></i>
                            </div>
                        </div>
                        <p class="text-gray-600 font-medium text-sm mb-6 max-w-xs mx-auto leading-relaxed">Silakan klik tombol di bawah ini, lalu dekatkan tag NFC ke area sensor HP Anda.</p>
                        <button type="button" onclick="startScan()" id="btn-scan" 
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-orange-400 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-orange-500/30 btn-modern">
                            <i class="fas fa-search"></i>
                            Mulai Scan NFC
                        </button>
                    </div>
                    
                    <div id="nfc-scanning" class="hidden">
                        <div class="w-24 h-24 bg-white shadow-lg shadow-orange-500/20 border-4 border-orange-100 rounded-full flex items-center justify-center text-orange-500 mx-auto mb-5 relative">
                            <div class="absolute inset-0 rounded-full border-4 border-orange-500 border-t-transparent animate-spin"></div>
                            <i class="fas fa-satellite-dish text-3xl animate-pulse"></i>
                        </div>
                        <p class="text-orange-600 font-bold text-lg">Mencari Tag NFC...</p>
                        <p class="text-gray-500 font-medium text-sm mt-2">Sedang memindai. Jangan jauhkan HP dari tag.</p>
                    </div>

                    <div id="nfc-success" class="hidden">
                        <div class="w-20 h-20 bg-emerald-50 shadow-sm border border-emerald-100 rounded-2xl flex items-center justify-center text-emerald-500 mx-auto mb-5 animate-bounce">
                            <i class="fas fa-check-circle text-4xl"></i>
                        </div>
                        <p class="text-emerald-600 font-bold text-lg">Tag Berhasil Terbaca!</p>
                        <div class="mt-4 bg-white border border-gray-100 inline-block px-6 py-2 rounded-xl shadow-sm">
                            <p id="scanned-uid" class="font-mono text-xl font-bold text-gray-800 tracking-widest"></p>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="nfc_uid" id="nfc_uid_input" required>
                @error('nfc_uid')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-3">
                <label class="block text-sm font-extrabold text-gray-800 uppercase tracking-widest">2. Detail Barang</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-box text-orange-400"></i>
                    </div>
                    <input type="text" name="nama_barang" required
                        class="block w-full pl-11 pr-4 py-4 border-2 border-gray-100 bg-gray-50 rounded-2xl font-medium focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white transition-all outline-none text-gray-800"
                        placeholder="Contoh: Laptop Asus ROG">
                </div>
                @error('nama_barang')
                    <p class="text-red-500 font-medium text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <button type="submit" id="btn-save" disabled
                class="w-full bg-gray-100 text-gray-400 font-bold py-4 px-4 rounded-2xl transition-all cursor-not-allowed disabled:opacity-70 disabled:shadow-none hover:shadow-lg focus:outline-none">
                <i class="fas fa-save mr-2 hidden" id="save-icon"></i> Simpan Barang
            </button>
        </form>
    </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/nfc-admin.js') }}"></script>
@endpush
@endsection
