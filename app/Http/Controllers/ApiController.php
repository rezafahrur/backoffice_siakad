<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Traits\TokenTrait;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    use TokenTrait;
    public function getToken()
    {
        // Ambil token saat ini dari database
        $this->generateToken();
        return response(200);
    }

    public function getJenisTinggal()
    {
        $response = $this->GetWebServices("GetJenisTinggal");

        if (isset($response['data'])) {
            usort($response['data'], function ($a, $b) {
                return $a['id_jenis_tinggal'] <=> $b['id_jenis_tinggal'];
            });
        }

        return $response;
    }

    public function getAlatTransportasi()
    {
        $response = $this->GetWebServices("GetAlatTransportasi");

        if (isset($response['data'])) {
            usort($response['data'], function ($a, $b) {
                return $a['id_alat_transportasi'] <=> $b['id_alat_transportasi'];
            });
        }

        return $response;
    }

    public function getAgama()
    {
        $response = $this->GetWebServices("GetAgama");

        if (isset($response['data'])) {
            usort($response['data'], function ($a, $b) {
                return $a['id_agama'] <=> $b['id_agama'];
            });
        }

        return $response;
    }

    public function getNegara()
    {
        $response = $this->GetWebServices("GetNegara");

        if (isset($response['data'])) {
            usort($response['data'], function ($a, $b) {
                return $a['id_negara'] <=> $b['id_negara'];
            });
        }

        return $response;
    }

    public function getPekerjaan()
    {
        $response = $this->GetWebServices("GetPekerjaan");

        if (isset($response['data'])) {
            usort($response['data'], function ($a, $b) {
                return $a['id_pekerjaan'] <=> $b['id_pekerjaan'];
            });
        }

        return $response;
    }

    public function getWilayah($request)
    {
        $kecamatan = ucwords(strtolower($request));
        $response = $this->GetWebServices("GetWilayah", "nama_wilayah = 'Kec. $kecamatan'");
        if (isset($response['data'])) {
            $response['data'] = array_map(function ($item) {
                return $item['id_wilayah'];
            }, $response['data']);
        }
        return $response['data'];
    }

    public function getPenghasilan()
    {
        $response = $this->GetWebServices("GetPenghasilan");

        if (isset($response['data'])) {
            usort($response['data'], function ($a, $b) {
                return $a['id_penghasilan'] <=> $b['id_penghasilan'];
            });
        }

        return $response;
    }

    public function getJenjangPendidikan()
    {
        $response = $this->GetWebServices("GetJenjangPendidikan");

        if (isset($response['data'])) {
            usort($response['data'], function ($a, $b) {
                return $a['id_jenjang_didik'] <=> $b['id_jenjang_didik'];
            });
        }

        return $response;
    }

    public function getKebutuhanKhusus($request)
    {
        $response = $this->GetWebServices("GetKebutuhanKhusus", "nama_kebutuhan_khusus = '$request'");

        if (isset($response['data'])) {
            $response['data'] = array_map(function ($item) {
                return $item['id_kebutuhan_khusus'];
            }, $response['data']);
        }
        
        return $response['data'];
    }
}
