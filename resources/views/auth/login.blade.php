@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center animate-fade-in">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/50 p-8 sm:p-10 border border-orange-50 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-orange-400 to-orange-500"></div>
            <div class="text-center mb-8 mt-2">
                <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 text-3xl mx-auto mb-4 shadow-sm border border-orange-100">
                    <i class="fas fa-fingerprint"></i>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Welcome Back</h1>
                <p class="text-gray-500 mt-2 font-medium">Sign in to manage your inventory</p>
            </div>

            <form action="{{ url('/login') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-widest">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-orange-400">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="username" required
                            class="block w-full pl-11 pr-4 py-3.5 border-2 border-gray-100 bg-gray-50 rounded-2xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white transition-all outline-none font-medium text-gray-800"
                            placeholder="Enter your username">
                    </div>
                    @error('username')
                        <p class="text-red-500 text-sm font-medium mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-800 uppercase tracking-widest">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-orange-400">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" required
                            class="block w-full pl-11 pr-4 py-3.5 border-2 border-gray-100 bg-gray-50 rounded-2xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white transition-all outline-none font-medium text-gray-800"
                            placeholder="Enter your password">
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white font-bold py-4 px-4 rounded-2xl shadow-xl shadow-orange-500/30 transition-all btn-modern">
                    Sign In
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-500 font-medium">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-orange-600 font-extrabold hover:text-orange-700 transition-colors">Daftar Sekarang</a>
                </p>
                <p class="text-[10px] text-gray-400 mt-5 font-bold uppercase tracking-widest">
                    NFC Inventory Premium v1.0
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
