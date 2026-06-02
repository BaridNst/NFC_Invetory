<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $history = Peminjaman::where('id_user', Auth::id())
            ->with('barang')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $activeLoans = Peminjaman::where('id_user', Auth::id())
            ->whereIn('status', ['pending_pinjam', 'dipinjam', 'pending_kembali'])
            ->count();

        $listTersedia = Barang::where('status_barang', 'tersedia')->get();
        $listDipinjam = Barang::where('status_barang', 'dipinjam')->get();

        return view('user.dashboard', compact('history', 'activeLoans', 'listTersedia', 'listDipinjam'));
    }

    public function tapping()
    {
        return view('user.tapping');
    }

    public function processTap(Request $request)
    {
        $request->validate([
            'nfc_uid' => 'required'
        ]);

        $barang = Barang::where('nfc_uid', $request->nfc_uid)->first();

        if (!$barang) {
            return response()->json(['success' => false, 'message' => 'Barang tidak terdaftar!'], 404);
        }

        // Cek apakah user sudah meminjam barang lain atau ada request pending
        $activeUserLoan = Peminjaman::where('id_user', Auth::id())
            ->whereIn('status', ['pending_pinjam', 'dipinjam', 'pending_kembali'])
            ->first();

        if ($barang->status_barang === 'tersedia') {
            if ($activeUserLoan) {
                return response()->json(['success' => false, 'message' => 'Anda hanya bisa meminjam 1 barang pada satu waktu!'], 403);
            }

            // Proses Pinjam -> Pending
            Peminjaman::create([
                'id_user' => Auth::id(),
                'id_barang' => $barang->id_barang,
                'tgl_pinjam' => now(),
                'status' => 'pending_pinjam'
            ]);

            $barang->update(['status_barang' => 'pending_pinjam']);

            return response()->json([
                'success' => true, 
                'message' => 'Pending peminjaman: ' . $barang->nama_barang . '. Menunggu konfirmasi Admin.',
                'type' => 'borrow'
            ]);
        } elseif ($barang->status_barang === 'dipinjam') {
            // Proses Kembali -> Pending
            $peminjaman = Peminjaman::where('id_barang', $barang->id_barang)
                ->where('status', 'dipinjam')
                ->latest()
                ->first();

            if ($peminjaman) {
                if ($peminjaman->id_user != Auth::id()) {
                    return response()->json([
                        'success' => false, 
                        'message' => 'Barang ini sedang dipinjam oleh orang lain!'
                    ], 403);
                }

                $peminjaman->update(['status' => 'pending_kembali']);
                $barang->update(['status_barang' => 'pending_kembali']);

                return response()->json([
                    'success' => true, 
                    'message' => 'Pending pengembalian: ' . $barang->nama_barang . '. Menunggu konfirmasi Admin.',
                    'type' => 'return'
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Data peminjaman tidak ditemukan!'], 404);
        } elseif (in_array($barang->status_barang, ['pending_pinjam', 'pending_kembali'])) {
            return response()->json([
                'success' => false, 
                'message' => 'Status barang sedang menunggu konfirmasi admin!'
            ], 403);
        }

        return response()->json(['success' => false, 'message' => 'Status barang tidak valid!'], 400);
    }
}
