<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Kirim pesan WhatsApp menggunakan Fonnte API Gateway.
     * Fallback ke laravel.log jika token tidak dikonfigurasi.
     *
     * @param string $target Nomor penerima (contoh: 08123456789)
     * @param string $message Isi pesan
     * @return bool
     */
    public static function sendMessage(string $target, string $message): bool
    {
        $token = env('FONNTE_TOKEN');

        // Normalisasi nomor wa jika masih diawali '0' ke '62' (dibutuhkan beberapa gateway, fonnte bisa otomatis tapi lebih aman normalisasi)
        if (str_starts_with($target, '0')) {
            $target = '62' . substr($target, 1);
        }

        if (empty($token) || $token === 'YOUR_FONNTE_TOKEN') {
            Log::info("=== SIMULASI WHATSAPP GATEWAY ===");
            Log::info("Pengirim (Admin): 6285212583609");
            Log::info("Kirim ke (Peminjam): " . $target);
            Log::info("Isi Pesan:\n" . $message);
            Log::info("=================================");
            return true;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'sender' => '6285212583609',
                'countryCode' => '62'
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp terkirim ke {$target} melalui Fonnte.");
                return true;
            }

            Log::error("Gagal mengirim WhatsApp ke {$target}. Respon: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("Exception saat kirim WhatsApp ke {$target}: " . $e->getMessage());
            return false;
        }
    }
}
