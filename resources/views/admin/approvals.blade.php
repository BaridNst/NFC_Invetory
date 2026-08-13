@extends('layouts.app')

@section('title', 'Persetujuan Peminjaman')

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
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-3">
                <span class="w-12 h-12 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-500 shadow-md shadow-orange-100">
                    <i class="fas fa-tasks"></i>
                </span>
                Persetujuan Peminjaman
            </h1>
            <p class="text-gray-500 mt-2 font-medium">Verifikasi dan atur batas waktu pengembalian inventaris laboratorium</p>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-3xl shadow-xl shadow-orange-100/40 border border-orange-50/50 overflow-hidden">
        <div class="p-6 sm:p-8">
            @if($pendingRequests->isEmpty())
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-orange-100/50">
                        <i class="fas fa-clipboard-check text-3xl text-orange-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Semua Bersih!</h3>
                    <p class="text-gray-500 mt-1 font-medium max-w-sm mx-auto">Tidak ada pengajuan peminjaman atau pengembalian barang yang tertunda saat ini.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-orange-100">
                                <th class="pb-4 font-bold text-xs text-gray-500 uppercase tracking-widest">Peminjam</th>
                                <th class="pb-4 font-bold text-xs text-gray-500 uppercase tracking-widest">Barang / NFC UID</th>
                                <th class="pb-4 font-bold text-xs text-gray-500 uppercase tracking-widest">Waktu Pengajuan</th>
                                <th class="pb-4 font-bold text-xs text-gray-500 uppercase tracking-widest">Tipe Aksi</th>
                                <th class="pb-4 text-right font-bold text-xs text-gray-500 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-orange-50/50">
                            @foreach($pendingRequests as $request)
                                <tr class="hover:bg-orange-50/10 transition-colors group">
                                    <td class="py-5 pr-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-orange-600 font-bold shadow-sm">
                                                {{ strtoupper(substr($request->user->nama, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-800">{{ $request->user->nama }}</div>
                                                <div class="text-xs text-gray-500 font-medium flex items-center gap-1 mt-0.5">
                                                    <i class="fab fa-whatsapp text-green-500"></i> {{ $request->user->no_wa ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5 pr-4">
                                        <div class="font-bold text-gray-800">{{ $request->barang->nama_barang }}</div>
                                        <div class="text-xs text-orange-500 font-mono font-semibold mt-0.5">
                                            <i class="fas fa-tag"></i> {{ $request->barang->nfc_uid }}
                                        </div>
                                    </td>
                                    <td class="py-5 pr-4">
                                        <div class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($request->created_at)->format('d-m-Y') }}</div>
                                        <div class="text-xs text-gray-500 font-medium mt-0.5">
                                            <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($request->created_at)->format('H:i') }} WIB
                                        </div>
                                    </td>
                                    <td class="py-5 pr-4">
                                        @if($request->status === 'pending_pinjam')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                                Peminjaman
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold bg-purple-50 text-purple-600 border border-purple-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span>
                                                Pengembalian
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-5 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2.5">
                                            @if($request->status === 'pending_pinjam')
                                                <!-- Peminjaman Approval: Open modal -->
                                                <button onclick="openApproveModal({{ $request->id_peminjaman }}, '{{ $request->user->nama }}', '{{ $request->barang->nama_barang }}', '{{ $request->user->no_wa ?? '' }}')" 
                                                    class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white text-xs font-extrabold rounded-xl shadow-md shadow-orange-500/20 transition-all btn-modern flex items-center gap-1.5">
                                                    <i class="fas fa-check"></i> Setujui
                                                </button>
                                            @else
                                                <!-- Pengembalian Approval: Direct POST form -->
                                                <form action="{{ route('admin.peminjaman.approve', $request->id_peminjaman) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-purple-500 hover:from-purple-700 hover:to-purple-600 text-white text-xs font-extrabold rounded-xl shadow-md shadow-purple-500/20 transition-all btn-modern flex items-center gap-1.5">
                                                        <i class="fas fa-check"></i> Setujui Kembali
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.peminjaman.reject', $request->id_peminjaman) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')"
                                                    class="px-4 py-2 bg-white border-2 border-gray-100 hover:border-red-200 hover:bg-red-50 text-gray-500 hover:text-red-500 text-xs font-bold rounded-xl transition-all flex items-center gap-1.5">
                                                    <i class="fas fa-times"></i> Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Atur Batas Waktu Peminjaman -->
<div id="approveModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeApproveModal()"></div>

    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-3xl shadow-2xl border border-orange-50 w-full max-w-md overflow-hidden transform transition-all">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-orange-400 to-orange-500"></div>
            
            <div class="p-6 sm:p-8">
                <!-- Close Button -->
                <button onclick="closeApproveModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>

                <div class="mb-6">
                    <h3 class="text-xl font-extrabold text-gray-900">Setujui Peminjaman</h3>
                    <p class="text-gray-500 text-sm mt-1 font-medium">Tentukan waktu pengembalian untuk barang ini</p>
                </div>

                <!-- Info Box -->
                <div class="bg-orange-50/50 border border-orange-100/50 rounded-2xl p-4 mb-6 text-sm font-semibold text-gray-800 space-y-1">
                    <div>Peminjam: <span id="modalUser" class="text-orange-600"></span></div>
                    <div>Barang: <span id="modalBarang" class="text-orange-600"></span></div>
                </div>

                <form id="approveForm" method="POST" class="space-y-5">
                    @csrf

                    <!-- Pilihan 2: Pilih Tanggal & Jam Kembali -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800 uppercase tracking-widest">Tanggal & Waktu Pengembalian</label>
                        <input type="datetime-local" name="tgl_harus_kembali" id="tgl_harus_kembali" required class="block w-full px-4 py-3 border-2 border-gray-100 bg-gray-50 rounded-2xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white transition-all outline-none font-medium text-gray-800">
                    </div>

                    <!-- Input Nomor WhatsApp Peminjam -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-800 uppercase tracking-widest">Nomor WhatsApp Peminjam</label>
                        <input type="text" name="no_wa" id="no_wa" required class="block w-full px-4 py-3 border-2 border-gray-100 bg-gray-50 rounded-2xl focus:ring-4 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white transition-all outline-none font-medium text-gray-800" placeholder="Contoh: 08123456789">
                    </div>

                    <div class="flex items-center gap-3 mt-8">
                        <button type="button" onclick="closeApproveModal()" class="w-1/2 px-4 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-2xl transition-all text-center">
                            Batal
                        </button>
                        <button type="submit" class="w-1/2 px-4 py-3.5 bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white font-bold rounded-2xl shadow-xl shadow-orange-500/25 transition-all text-center">
                            Konfirmasi ACC
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openApproveModal(id, user, barang, noWa) {
        const modal = document.getElementById('approveModal');
        const form = document.getElementById('approveForm');
        document.getElementById('modalUser').innerText = user;
        document.getElementById('modalBarang').innerText = barang;
        
        // Set action form dynamically
        form.action = `/admin/peminjaman/${id}/approve`;
        
        // Populate fields
        document.getElementById('tgl_harus_kembali').value = '';
        document.getElementById('no_wa').value = noWa;

        // Show modal
        modal.classList.remove('hidden');
    }

    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
