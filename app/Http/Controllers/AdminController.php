<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBarang = Barang::count();
        $tersedia = Barang::where('status_barang', 'tersedia')->count();
        $dipinjam = Barang::where('status_barang', 'dipinjam')->count();
        $transaksi = Peminjaman::count();

        $listTersedia = Barang::where('status_barang', 'tersedia')->get();
        $listDipinjam = Barang::where('status_barang', 'dipinjam')->get();

        $activeLoans = Peminjaman::with(['user', 'barang'])
            ->where('status', 'dipinjam')
            ->orderBy('tgl_harus_kembali', 'asc')
            ->get();

        $pendingRequests = Peminjaman::with(['user', 'barang'])
            ->whereIn('status', ['pending_pinjam', 'pending_kembali'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.dashboard', compact('totalBarang', 'tersedia', 'dipinjam', 'transaksi', 'listTersedia', 'listDipinjam', 'pendingRequests', 'activeLoans'));
    }

    public function items()
    {
        $items = Barang::with(['latestPeminjaman.user'])->get();
        return view('admin.items.index', compact('items'));
    }

    public function createItem()
    {
        return view('admin.items.create');
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'nfc_uid' => 'required|unique:barang,nfc_uid',
        ]);

        Barang::create($request->all());

        return redirect()->route('admin.items')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function deleteItem($id)
    {
        Barang::destroy($id);
        return back()->with('success', 'Barang berhasil dihapus.');
    }

    public function history()
    {
        $history = Peminjaman::with(['user', 'barang'])->orderBy('created_at', 'desc')->get();
        return view('admin.history', compact('history'));
    }

    public function report()
    {
        $history = Peminjaman::with(['user', 'barang'])->orderBy('created_at', 'desc')->get();
        return view('admin.report', compact('history'));
    }

    public function approvals()
    {
        $pendingRequests = Peminjaman::with(['user', 'barang'])
            ->whereIn('status', ['pending_pinjam', 'pending_kembali'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.approvals', compact('pendingRequests'));
    }

    public function approve(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = Barang::findOrFail($peminjaman->id_barang);

        if ($peminjaman->status === 'pending_pinjam') {
            $request->validate([
                'tgl_harus_kembali' => 'required|date|after:now',
                'no_wa' => 'required|string|max:20',
            ]);

            $now = now();
            $tglHarusKembali = $request->tgl_harus_kembali;

            // Update nomor WA peminjam jika disunting admin
            $peminjaman->user->update(['no_wa' => $request->no_wa]);

            $peminjaman->update([
                'status' => 'dipinjam',
                'tgl_pinjam' => $now,
                'tgl_harus_kembali' => $tglHarusKembali,
                'wa_sent' => false,
            ]);
            $barang->update(['status_barang' => 'dipinjam']);
            return back()->with('success', 'Peminjaman disetujui. Batas pengembalian: ' . \Carbon\Carbon::parse($tglHarusKembali)->format('d-m-Y H:i'));
        } elseif ($peminjaman->status === 'pending_kembali') {
            $tglKembali = now();
            // Hitung denda final
            $denda = 0;
            if ($peminjaman->tgl_harus_kembali && $tglKembali > $peminjaman->tgl_harus_kembali) {
                $menitTerlambat = (int) $peminjaman->tgl_harus_kembali->diffInMinutes($tglKembali, false);
                if ($menitTerlambat > 0) {
                    $denda = $menitTerlambat * 1000;
                }
            }

            $peminjaman->update([
                'status' => 'dikembalikan',
                'tgl_kembali' => $tglKembali,
                'denda' => $denda
            ]);
            $barang->update(['status_barang' => 'tersedia']);
            
            $successMsg = 'Pengembalian disetujui.';
            if ($denda > 0) {
                $successMsg .= ' Denda yang harus dibayar: Rp ' . number_format($denda, 0, ',', '.');
            }
            return back()->with('success', $successMsg);
        }

        return back()->with('error', 'Status tidak valid.');
    }

    public function reject(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = Barang::findOrFail($peminjaman->id_barang);

        if ($peminjaman->status === 'pending_pinjam') {
            $peminjaman->update(['status' => 'ditolak']);
            $barang->update(['status_barang' => 'tersedia']);
            return back()->with('success', 'Peminjaman ditolak.');
        } elseif ($peminjaman->status === 'pending_kembali') {
            $peminjaman->update(['status' => 'dipinjam']);
            $barang->update(['status_barang' => 'dipinjam']);
            return back()->with('success', 'Pengembalian ditolak.');
        }

        return back()->with('error', 'Status tidak valid.');
    }
}
