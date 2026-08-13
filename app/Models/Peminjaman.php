<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_user',
        'id_barang',
        'tgl_pinjam',
        'tgl_kembali',
        'tgl_harus_kembali',
        'status',
        'denda',
        'wa_sent',
    ];

    protected $casts = [
        'tgl_pinjam' => 'datetime',
        'tgl_kembali' => 'datetime',
        'tgl_harus_kembali' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    // Hitung menit terlambat
    public function getMenitTerlambatAttribute()
    {
        if (!$this->tgl_harus_kembali) {
            return 0;
        }

        // Tentukan batas akhir (jika sudah dikembalikan pakai tgl_kembali, jika belum pakai waktu sekarang)
        $end = $this->tgl_kembali ?? now();

        if ($end <= $this->tgl_harus_kembali) {
            return 0;
        }

        // Hitung selisih menit
        return (int) $this->tgl_harus_kembali->diffInMinutes($end, false);
    }

    // Status terlambat: Terlambat atau Tepat Waktu
    public function getStatusTerlambatAttribute()
    {
        if (!$this->tgl_harus_kembali) {
            return 'Tepat Waktu';
        }

        $end = $this->tgl_kembali ?? now();
        return $end > $this->tgl_harus_kembali ? 'Terlambat' : 'Tepat Waktu';
    }

    // Ambil denda terhitung
    public function getDendaTerhitungAttribute()
    {
        // Jika sudah dikembalikan, pakai nilai denda yang tersimpan di DB agar tidak bertambah terus
        if ($this->status === 'dikembalikan') {
            return $this->denda;
        }

        // Jika belum dikembalikan, hitung secara dinamis
        return $this->menit_terlambat * 1000; // Rp 1.000 per menit terlambat
    }
}
