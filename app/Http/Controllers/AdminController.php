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

        $pendingRequests = Peminjaman::with(['user', 'barang'])
            ->whereIn('status', ['pending_pinjam', 'pending_kembali'])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.dashboard', compact('totalBarang', 'tersedia', 'dipinjam', 'transaksi', 'listTersedia', 'listDipinjam', 'pendingRequests'));
    }

    public function items()
    {
        $items = Barang::all();
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

    public function approve(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = Barang::findOrFail($peminjaman->id_barang);

        if ($peminjaman->status === 'pending_pinjam') {
            $peminjaman->update(['status' => 'dipinjam']);
            $barang->update(['status_barang' => 'dipinjam']);
            return back()->with('success', 'Peminjaman disetujui.');
        } elseif ($peminjaman->status === 'pending_kembali') {
            $peminjaman->update([
                'status' => 'dikembalikan',
                'tgl_kembali' => now()
            ]);
            $barang->update(['status_barang' => 'tersedia']);
            return back()->with('success', 'Pengembalian disetujui.');
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
