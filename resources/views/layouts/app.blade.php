<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NFC Inventory - @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/HIMA-TI.png') }}">
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
        ::-webkit-scrollbar-thumb { background: #fff7ed; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #f97316; }
    </style>
</head>
<body class="bg-[#FFFBF7] text-gray-800 antialiased selection:bg-orange-500 selection:text-white flex flex-col min-h-screen overflow-x-hidden">
    <!-- Navbar Premium -->
    <nav class="sticky top-0 z-50 glass-orange shadow-sm shadow-orange-100/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-2 sm:gap-8">
                    <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')) : url('/') }}" class="flex-shrink-0 flex items-center gap-2 sm:gap-3 group">
                        <img src="{{ asset('assets/HIMA-TI.png') }}" alt="HIMA-TI Logo" class="h-8 sm:h-12 w-auto object-contain group-hover:scale-105 transition-transform duration-300">
                        <span class="text-base sm:text-2xl font-extrabold tracking-tight text-gray-900">NFC<span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-400">Inv-</span>LAB</span>
                    </a>

                    @auth
                        @if(Auth::user()->role === 'admin' && !request()->routeIs('login') && !request()->routeIs('register'))
                            <div class="hidden md:flex items-center gap-4 border-l border-orange-100 pl-6">
                                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ request()->routeIs('admin.dashboard') ? 'bg-orange-100/50 text-orange-600' : 'text-gray-600 hover:bg-orange-50/50 hover:text-orange-600' }}">
                                    <i class="fas fa-th-large"></i> Dashboard
                                </a>
                                <a href="{{ route('admin.approvals') }}" class="px-3 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ request()->routeIs('admin.approvals') ? 'bg-orange-100/50 text-orange-600' : 'text-gray-600 hover:bg-orange-50/50 hover:text-orange-600' }}">
                                    <i class="fas fa-tasks"></i> Persetujuan
                                </a>
                                <a href="{{ route('admin.items') }}" class="px-3 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ request()->routeIs('admin.items') ? 'bg-orange-100/50 text-orange-600' : 'text-gray-600 hover:bg-orange-50/50 hover:text-orange-600' }}">
                                    <i class="fas fa-box-open"></i> Manajemen Barang
                                </a>
                                <a href="{{ route('admin.items.create') }}" class="px-3 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ request()->routeIs('admin.items.create') ? 'bg-orange-100/50 text-orange-600' : 'text-gray-600 hover:bg-orange-50/50 hover:text-orange-600' }}">
                                    <i class="fas fa-plus"></i> Tambah Barang
                                </a>
                                <a href="{{ route('admin.history') }}" class="px-3 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ request()->routeIs('admin.history') ? 'bg-orange-100/50 text-orange-600' : 'text-gray-600 hover:bg-orange-50/50 hover:text-orange-600' }}">
                                    <i class="fas fa-history"></i> Riwayat Transaksi
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>
                <div class="flex items-center gap-2 sm:gap-5">
                    @auth
                        @if(!request()->routeIs('login') && !request()->routeIs('register'))
                            <div class="hidden md:flex flex-col text-right justify-center">
                                <div class="text-sm font-bold text-gray-800">{{ Auth::user()->nama }}</div>
                                <div class="text-[11px] text-orange-600 font-bold uppercase tracking-widest bg-orange-100 px-2 py-0.5 rounded-md self-end mt-1">{{ Auth::user()->role }}</div>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="button" id="logout-trigger" class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-all btn-modern shadow-sm">
                                    <i class="fas fa-sign-out-alt text-sm sm:text-base"></i>
                                </button>
                            </form>
                            @if(Auth::user()->role === 'admin')
                                <button id="mobile-menu-button" class="md:hidden w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-400 hover:text-orange-500 hover:border-orange-200 transition-all btn-modern shadow-sm">
                                    <i class="fas fa-bars text-sm sm:text-base"></i>
                                </button>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        @auth
            @if(Auth::user()->role === 'admin' && !request()->routeIs('login') && !request()->routeIs('register'))
                <div id="mobile-menu" class="hidden md:hidden border-t border-orange-100 bg-white px-4 py-4 space-y-2 shadow-inner">
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ request()->routeIs('admin.dashboard') ? 'bg-orange-100/50 text-orange-600' : 'text-gray-600 hover:bg-orange-50/50 hover:text-orange-600' }}">
                        <i class="fas fa-th-large"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.approvals') }}" class="block px-4 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ request()->routeIs('admin.approvals') ? 'bg-orange-100/50 text-orange-600' : 'text-gray-600 hover:bg-orange-50/50 hover:text-orange-600' }}">
                        <i class="fas fa-tasks"></i> Persetujuan
                    </a>
                    <a href="{{ route('admin.items') }}" class="block px-4 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ request()->routeIs('admin.items') ? 'bg-orange-100/50 text-orange-600' : 'text-gray-600 hover:bg-orange-50/50 hover:text-orange-600' }}">
                        <i class="fas fa-box-open"></i> Manajemen Barang
                    </a>
                    <a href="{{ route('admin.items.create') }}" class="block px-4 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ request()->routeIs('admin.items.create') ? 'bg-orange-100/50 text-orange-600' : 'text-gray-600 hover:bg-orange-50/50 hover:text-orange-600' }}">
                        <i class="fas fa-plus"></i> Tambah Barang
                    </a>
                    <a href="{{ route('admin.history') }}" class="block px-4 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2 {{ request()->routeIs('admin.history') ? 'bg-orange-100/50 text-orange-600' : 'text-gray-600 hover:bg-orange-50/50 hover:text-orange-600' }}">
                        <i class="fas fa-history"></i> Riwayat Transaksi
                    </a>
                </div>
            @endif
        @endauth
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

    <!-- Logout Confirmation Modal -->
    <div id="logout-modal" class="fixed inset-0 z-[100] flex items-center justify-center hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop with blur -->
        <div id="logout-backdrop" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0"></div>

        <!-- Modal Content Box (Glassmorphism & Orange/Red Theme) -->
        <div id="logout-modal-content" class="relative bg-white border border-orange-200 rounded-3xl p-6 max-w-sm w-full mx-4 shadow-2xl shadow-orange-100/30 transform scale-95 opacity-0 transition-all duration-300 ease-out z-10">
            <div class="text-center">
                <!-- Icon with soft background & glow -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-2xl bg-gradient-to-br from-orange-50 to-red-50 text-orange-500 border border-orange-100 mb-4 shadow-inner">
                    <i class="fas fa-sign-out-alt text-2xl bg-clip-text bg-gradient-to-r from-orange-500 to-red-500"></i>
                </div>
                
                <h3 class="text-lg font-bold text-gray-900 mb-1" id="modal-title">Keluar Aplikasi</h3>
                <p class="text-sm text-gray-500 mb-6 leading-relaxed">Apakah anda yakin ingin keluar?</p>
                
                <div class="flex gap-3 justify-center">
                    <button type="button" id="logout-cancel" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]">
                        Tidak
                    </button>
                    <button type="button" id="logout-confirm" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold rounded-xl text-sm transition-all duration-200 shadow-md shadow-orange-200/50 hover:scale-[1.02] active:scale-[0.98]">
                        Iya
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile menu toggle
            const btn = document.getElementById('mobile-menu-button');
            const menu = document.getElementById('mobile-menu');
            if (btn && menu) {
                btn.addEventListener('click', function () {
                    menu.classList.toggle('hidden');
                });
            }

            // Logout modal logic
            const logoutTrigger = document.getElementById('logout-trigger');
            const logoutModal = document.getElementById('logout-modal');
            const logoutBackdrop = document.getElementById('logout-backdrop');
            const logoutContent = document.getElementById('logout-modal-content');
            const logoutCancel = document.getElementById('logout-cancel');
            const logoutConfirm = document.getElementById('logout-confirm');
            const logoutForm = document.getElementById('logout-form');

            if (logoutTrigger && logoutModal && logoutBackdrop && logoutContent && logoutCancel && logoutConfirm && logoutForm) {
                function openModal() {
                    // Show modal container
                    logoutModal.classList.remove('hidden');
                    // Trigger browser paint to ensure transition happens
                    void logoutModal.offsetWidth;
                    // Transition in
                    logoutBackdrop.classList.remove('opacity-0');
                    logoutBackdrop.classList.add('opacity-100');
                    logoutContent.classList.remove('scale-95', 'opacity-0');
                    logoutContent.classList.add('scale-100', 'opacity-100');
                    document.body.classList.add('overflow-hidden');
                }

                function closeModal() {
                    // Transition out
                    logoutBackdrop.classList.remove('opacity-100');
                    logoutBackdrop.classList.add('opacity-0');
                    logoutContent.classList.remove('scale-100', 'opacity-100');
                    logoutContent.classList.add('scale-95', 'opacity-0');
                    document.body.classList.remove('overflow-hidden');

                    // Hide container after transition
                    setTimeout(() => {
                        if (logoutBackdrop.classList.contains('opacity-0')) {
                            logoutModal.classList.add('hidden');
                        }
                    }, 300); // matches the transition duration (duration-300)
                }

                logoutTrigger.addEventListener('click', function (e) {
                    e.preventDefault();
                    openModal();
                });

                logoutCancel.addEventListener('click', closeModal);
                logoutBackdrop.addEventListener('click', closeModal);

                logoutConfirm.addEventListener('click', function () {
                    logoutForm.submit();
                });

                // Close on Escape key press
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && !logoutModal.classList.contains('hidden')) {
                        closeModal();
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
