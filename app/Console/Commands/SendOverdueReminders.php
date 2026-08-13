<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('reminder:whatsapp')]
#[Description('Kirim pengingat WhatsApp otomatis untuk peminjaman yang melewati batas waktu')]
class SendOverdueReminders extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memeriksa peminjaman yang terlambat...');

        $overdueLoans = \App\Models\Peminjaman::with(['user', 'barang'])
            ->where('status', 'dipinjam')
            ->whereNotNull('tgl_harus_kembali')
            ->where('tgl_harus_kembali', '<', now())
            ->where('wa_sent', false)
            ->get();

        if ($overdueLoans->isEmpty()) {
            $this->info('Tidak ada peminjaman terlambat yang memerlukan pengingat baru.');
            return 0;
        }

        foreach ($overdueLoans as $loan) {
            $user = $loan->user;
            $barang = $loan->barang;

            if (!$user || !$user->no_wa) {
                $this->warn("User ID {$loan->id_user} tidak memiliki nomor WhatsApp.");
                continue;
            }

            $tglHarusKembaliFormatted = $loan->tgl_harus_kembali->format('d-m-Y H:i');
            
            $message = "Mohon segera kembalikan barang tersebut ke laboratorium dan jika anda terlambat anda akan terkena sanksi denda.\n\n"
                     . "Sekian Terima kasih.";

            $this->info("Mengirim pesan ke {$user->nama} ({$user->no_wa})...");
            
            $sent = \App\Services\WhatsAppService::sendMessage($user->no_wa, $message);

            if ($sent) {
                $loan->update(['wa_sent' => true]);
                $this->info("Pengingat berhasil dikirim ke {$user->nama}.");
            } else {
                $this->error("Gagal mengirim pengingat ke {$user->nama}.");
            }
        }

        $this->info('Selesai memproses pengingat.');
        return 0;
    }
}
