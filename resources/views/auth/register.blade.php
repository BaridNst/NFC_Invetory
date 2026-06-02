@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center animate-fade-in my-8">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/50 p-8 sm:p-10 border border-orange-50 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-orange-400 to-orange-500"></div>
            <div class="text-center mb-8 mt-2">
                <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 text-3xl mx-auto mb-4 shadow-sm border border-orange-100">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Create Account</h1>
                <p class="text-gray-500 mt-2 font-medium">Daftar untuk mulai meminjam inventaris</p>
            </div>

            <form action="{{ url('/register') }}" method="POST" class="space-y-5">
                @csrf
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-800 uppercase tracking-widest">Nama Lengkap</label>
                    <input type="text" name="nama" required
                        class="block w-full px-4 py-3.5 border-2 border-gray-100 bg-gray-50 rounded-2xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white transition-all outline-none font-medium text-gray-800"
                        placeholder="Contoh: Budi Santoso">
                    @error('nama')
                        <p class="text-red-500 text-sm font-medium mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-800 uppercase tracking-widest">Username</label>
                    <input type="text" name="username" required
                        class="block w-full px-4 py-3.5 border-2 border-gray-100 bg-gray-50 rounded-2xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white transition-all outline-none font-medium text-gray-800"
                        placeholder="Pilih username unik">
                    @error('username')
                        <p class="text-red-500 text-sm font-medium mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-800 uppercase tracking-widest">Password</label>
                    <input type="password" name="password" required
                        class="block w-full px-4 py-3.5 border-2 border-gray-100 bg-gray-50 rounded-2xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white transition-all outline-none font-medium text-gray-800"
                        placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="text-red-500 text-sm font-medium mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-800 uppercase tracking-widest">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="block w-full px-4 py-3.5 border-2 border-gray-100 bg-gray-50 rounded-2xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white transition-all outline-none font-medium text-gray-800"
                        placeholder="Ulangi password">
                </div>

                <button type="submit" 
                    class="w-full bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white font-bold py-4 px-4 rounded-2xl shadow-xl shadow-orange-500/30 transition-all btn-modern mt-6">
                    Register Now
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500 font-medium">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-orange-600 font-extrabold hover:text-orange-700 transition-colors">Sign In</a>
                </p>
                <p class="text-[10px] text-gray-400 mt-5 font-bold uppercase tracking-widest">
                    NFC Inventory Premium v1.0
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
