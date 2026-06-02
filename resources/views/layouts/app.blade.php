<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NFC Inventory - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-orange { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(249, 115, 22, 0.1); }
        .btn-modern { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .btn-modern:hover { transform: translateY(-3px); box-shadow: 0 12px 20px -8px rgba(249, 115, 22, 0.5); }
        .btn-modern:active { transform: translateY(1px); }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        /* Custom Orange Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #fff7ed; }
        ::-webkit-scrollbar-thumb { background: #fdba74; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #f97316; }
    </style>
</head>
<body class="bg-[#FFFBF7] text-gray-800 antialiased selection:bg-orange-500 selection:text-white flex flex-col min-h-screen">
    <!-- Navbar Premium -->
    <nav class="sticky top-0 z-50 glass-orange shadow-sm shadow-orange-100/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center gap-3 group cursor-pointer">
                        <div class="w-12 h-12 bg-gradient-to-tr from-orange-600 to-orange-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-orange-500/40 group-hover:scale-105 transition-transform duration-300">
                            <i class="fas fa-microchip text-xl"></i>
                        </div>
                        <span class="text-2xl font-extrabold tracking-tight text-gray-900">NFC<span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-400">Inv</span></span>
                    </div>
                </div>
                <div class="flex items-center gap-5">
                    @auth
                        <div class="hidden md:flex flex-col text-right justify-center">
                            <div class="text-sm font-bold text-gray-800">{{ Auth::user()->nama }}</div>
                            <div class="text-[11px] text-orange-600 font-bold uppercase tracking-widest bg-orange-100 px-2 py-0.5 rounded-md self-end mt-1">{{ Auth::user()->role }}</div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="ml-2">
                            @csrf
                            <button type="submit" class="w-10 h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-all btn-modern shadow-sm">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        @if(session('success'))
            <div class="mb-8 p-4 bg-orange-50 border-l-4 border-orange-500 text-orange-800 rounded-r-2xl shadow-md shadow-orange-100/50 flex items-center gap-3 animate-fade-in">
                <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-500">
                    <i class="fas fa-check"></i>
                </div>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="py-6 text-center text-gray-400 text-sm font-medium border-t border-orange-100/50 bg-white mt-auto">
        &copy; {{ date('Y') }} NFC Inventory <span class="text-orange-500 font-bold">Premium Edition</span>. Built with <i class="fas fa-heart text-orange-500 animate-pulse"></i>.
    </footer>

    @stack('scripts')
</body>
</html>
