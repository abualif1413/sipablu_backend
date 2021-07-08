<?php

namespace App\Http\Controllers\ProfilRumahSakit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InformasiUmumController extends Controller
{
    public function ubah(Request $req)
    {
        \App\Models\InformasiUmum::where('id_informasi_rumah_sakit', '<>', '0')->delete();

        $info = new \App\Models\InformasiUmum;
        $info->kode_pusat = $req->kode_pusat;
        $info->kode = $req->kode;
        $info->nama = $req->nama;
        $info->tipe_fasyankes = $req->tipe_fasyankes;
        $info->kelas = $req->kelas;
        $info->provinsi = $req->provinsi;
        $info->kabupaten = $req->kabupaten;
        $info->kecamatan = $req->kecamatan;
        $info->kelurahan = $req->kelurahan;
        $info->alamat = $req->alamat;
        $info->kode_pos = $req->kode_pos;
        $info->telepon = $req->telepon;
        $info->fax = $req->fax;
        $info->email = $req->email;
        $info->website = $req->website;
        $info->save();

        return response()->json(["success" => 1]);
    }
}
