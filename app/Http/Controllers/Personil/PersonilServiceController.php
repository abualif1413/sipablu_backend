<?php

namespace App\Http\Controllers\Personil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonilServiceController extends Controller
{
    //
    public function getService(Request $req, $tipe) {
        $upsvc = \App\Models\PersonilService::where('tipe', $tipe)->first();

        return response()->json($upsvc);
    }

    public function getPangkat(Request $req, $tipe)
    {
        $pangkat = \App\Models\Pangkat::where('tipe', $tipe)->orderby('pangkat', 'asc')->get();

        return response()->json($pangkat);
    }

    public function getPendidikan(Request $req)
    {
        $pendidikan = \App\Models\Pendidikan::orderBy('id', 'asc')->get();

        return response()->json($pendidikan);
    }

    public function add(Request $req)
    {
        $personil = new \App\Models\Personil;
        $personil->tipe = $req->tipe;
        $personil->nama = $req->nama;
        $personil->nrp = $req->nrp;
        $personil->id_pangkat = $req->id_pangkat;
        $personil->jenkel = $req->jenkel;
        $personil->tempat_lahir = $req->tempat_lahir;
        $personil->tgl_lahir = $req->tgl_lahir;
        $personil->jabatan = $req->jabatan;
        $personil->tgl_masuk = $req->tgl_masuk;
        $personil->tgl_keluar = $req->tgl_keluar;
        $personil->alasan_keluar = $req->alasan_keluar;
        $personil->status = $req->status;
        $personil->id_pendidikan = $req->id_pendidikan;
        $personil->str = $req->str;
        $personil->save();

        return response()->json(["success" => 1]);
    }

    public function update(Request $req)
    {
        $personil = \App\Models\Personil::find($req->id);
        $personil->tipe = $req->tipe;
        $personil->nama = $req->nama;
        $personil->nrp = $req->nrp;
        $personil->id_pangkat = $req->id_pangkat;
        $personil->jenkel = $req->jenkel;
        $personil->tempat_lahir = $req->tempat_lahir;
        $personil->tgl_lahir = $req->tgl_lahir;
        $personil->jabatan = $req->jabatan;
        $personil->tgl_masuk = $req->tgl_masuk;
        $personil->tgl_keluar = $req->tgl_keluar;
        $personil->alasan_keluar = $req->alasan_keluar;
        $personil->status = $req->status;
        $personil->id_pendidikan = $req->id_pendidikan;
        $personil->str = $req->str;
        $personil->save();

        return response()->json(["success" => 1]);
    }

    public function find($id)
    {
        $personil = \App\Models\Personil::find($id);

        return response()->json($personil);
    }

    public function all_personil(Request $req, $tipe)
    {
        $personil = \App\Models\Personil::leftJoin('t_pangkat', 't_personil.id_pangkat', 't_pangkat.id')
                    ->leftJoin('t_pendidikan', 't_personil.id_pendidikan', 't_pendidikan.id')
                    ->where('t_personil.tipe', $tipe)
                    ->orderBy('t_personil.nama', 'asc')
                    ->orderBy('t_personil.nrp', 'asc')
                    ->select('t_personil.*', 't_pangkat.pangkat', 't_pendidikan.pendidikan')
                    ->paginate(10);

        return response()->json($personil);
    }
}
