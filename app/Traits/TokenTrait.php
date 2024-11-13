<?php

namespace App\Traits;

use App\Models\Config;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

trait TokenTrait
{
    function generateToken()
    {
        // Ambil token saat ini dari database
        $currentToken = Config::where('key', 'TOKEN_NEOFEEDER')->value('value');

        $response = Http::withHeaders([
            'passphrase' => 'Eaubt2J3XvOZrcWjl5QUMDm0DdqSaQFHZc66F5KcB7b0PuqLVZWV5X6ZedWSRbV1j1X9HID5Pd88wZjAFKKVBH5iWDC9am0PL7rRqpuEZjGR85Upd0HD8vCZd0fRfmRtl1sLwTOg5Uv9aSgQGcUmjkvTqX8XHyo6itbiVCXB2bg0WvBAz9Gfjeq85gf2g9Czi8Q34bf'
        ])->post('http://103.150.112.246:5407/buatinToken');

        if ($response->successful()) {
            $newToken = $response->json('token');

            // Simpan token baru hanya jika berbeda dengan token saat ini
            if ($currentToken !== $newToken) {
                Config::updateOrCreate(
                    ['key' => 'TOKEN_NEOFEEDER'],
                    ['value' => $newToken]
                );
            }

            return $newToken; // Kembalikan token baru
        } else {
            return ""; // Kembalikan string kosong jika gagal
        }
    }

    public function GetWebServices($act, $filter = ""){
        $client = new Client();
        try {
            // Ambil token dari konfigurasi
            $token = Config::where('key', 'TOKEN_NEOFEEDER')->value('value');

            // Request data dari API
            $response = $client->post('http://103.150.112.246:1289/ws/live2.php', [
                'json' => [
                    "act" => $act,
                    "Content-Type" => "application/json",
                    "token" => $token,
                    "filter" => $filter,
                    "limit" => 0,
                    "offset" => 0
                ]
            ]);

            // Decode JSON response
            $data = json_decode($response->getBody()->getContents(), true);

            return $data;
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan pesan error
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
