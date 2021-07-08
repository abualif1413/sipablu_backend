<?php

namespace App\Http\Controllers\Pelayanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelayananController extends Controller
{
    public function pelayananServiceFind(Request $req, $tipe)
    {
        $svc = \App\Models\PasienService::where('tipe', $tipe)->first();

        return response()->json($svc);
    }

    public function pelayananService(Request $req)
    {
        $svc = \App\Models\PasienService::orderBy('judul', 'asc')->get();

        return response()->json($svc);
    }

    public function allTipePembayaran(Request $req)
    {
        $tipe_pembayaran = \App\Models\TipePembayaran::orderBy('tipe_pembayaran', 'asc')->get();

        return response()->json($tipe_pembayaran);
    }

    public function allRuangan(Request $req)
    {
        $ruangan = \App\Models\Ruangan::orderBy('ruangan', 'asc')->get();

        return response()->json($ruangan);
    }

    public function allPoliklinik(Request $req)
    {
        $poli = \App\Models\Poliklinik::orderBy('poliklinik', 'asc')->get();

        return response()->json($poli);
    }

    public function add(Request $req)
    {
        $user = \App\Http\Controllers\MasterData\UserController::breakToken($req->bearerToken());

        $pasien = new \App\Models\Pasien;
        $pasien->nama = $req->nama;
        $pasien->jenkel = $req->jenkel;
        $pasien->tempat_lahir = $req->tempat_lahir;
        $pasien->tgl_lahir = $req->tgl_lahir;
        $pasien->catatan = $req->catatan;
        $pasien->tgl_berobat = $req->tgl_berobat;
        $pasien->tipe = $req->tipe;
        $pasien->id_ruangan = ($req->id_ruangan != "") ? $req->id_ruangan : null;
        $pasien->id_tipe_pembayaran = $req->id_tipe_pembayaran;
        $pasien->id_poliklinik = ($req->id_poliklinik != "") ? $req->id_poliklinik : null;
        $pasien->created_by = $user->id;
        $pasien->save();

        return response()->json(["success" => 1]);
    }

    public function update(Request $req)
    {
        $user = \App\Http\Controllers\MasterData\UserController::breakToken($req->bearerToken());

        $pasien = \App\Models\Pasien::find($req->id);
        $pasien->nama = $req->nama;
        $pasien->jenkel = $req->jenkel;
        $pasien->tempat_lahir = $req->tempat_lahir;
        $pasien->tgl_lahir = $req->tgl_lahir;
        $pasien->catatan = $req->catatan;
        $pasien->tgl_berobat = $req->tgl_berobat;
        $pasien->tipe = $req->tipe;
        $pasien->id_ruangan = ($req->id_ruangan != "") ? $req->id_ruangan : null;
        $pasien->id_tipe_pembayaran = $req->id_tipe_pembayaran;
        $pasien->id_poliklinik = ($req->id_poliklinik != "") ? $req->id_poliklinik : null;
        $pasien->updated_by = $user->id;
        $pasien->save();

        return response()->json(["success" => 1]);
    }

    public function delete(Request $req, $id)
    {
        $pasien = \App\Models\Pasien::find($req->id);
        $pasien->delete();

        return response()->json(["success" => 1]);
    }

    public function getAllPasien(Request $req, $tipe)
    {
        $service = \App\Models\Pasien::leftJoin('t_tipe_pembayaran', 't_pasien.id_tipe_pembayaran', 't_tipe_pembayaran.id_tipe_pembayaran')
                    ->leftJoin('t_ruangan', 't_pasien.id_ruangan', 't_ruangan.id_ruangan')
                    ->leftJoin('t_poliklinik', 't_pasien.id_poliklinik', 't_poliklinik.id_poliklinik')
                    ->where('tipe', $tipe)
                    ->whereBetween('tgl_berobat', array($req->dari, $req->sampai))
                    ->where(function($q) use($req, $tipe) {
                        if($req->id_ruangan != "") {
                            $q->where('t_pasien.id_ruangan', $req->id_ruangan);
                        }
                        if($req->id_poliklinik != "") {
                            $q->where('t_pasien.id_poliklinik', $req->id_poliklinik);
                        }
                    })
                    ->select('t_pasien.*', 't_tipe_pembayaran.tipe_pembayaran', 't_tipe_pembayaran.icons', 't_ruangan.ruangan', 't_poliklinik.poliklinik')
                    ->orderBy('t_pasien.tgl_berobat', 'desc')->orderBy('t_pasien.nama', 'asc')
                    ->paginate(10);

        return response()->json($service);
    }

    public function findPasien(Request $req, $id)
    {
        $pasien = \App\Models\Pasien::find($id);

        return response()->json($pasien);
    }

    public function chartKunjunganPerKegiatan(Request $req, $periode)
    {
        $data = DB::select(
            DB::raw("
                SELECT
                    svc.judul, COUNT(pas.id_pasien) AS jumlah
                FROM
                    t_pasien_service svc
                    LEFT JOIN t_pasien pas ON svc.tipe = pas.tipe AND SUBSTR(pas.tgl_berobat,1,7) = ?
                GROUP BY
                    svc.judul
                ORDER BY
                    svc.judul ASC
            "), [$periode]
        );

        return response()->json($data);
    }

    public function chartKunjunganRawatInap(Request $req, $periode)
    {
        $data = DB::select(
            DB::raw("
                SELECT
                    room.ruangan, COUNT(pas.id_pasien) AS jumlah
                FROM
                    t_ruangan room
                    LEFT JOIN t_pasien pas ON room.id_ruangan = pas.id_ruangan AND SUBSTR(pas.tgl_berobat,1,7) = ? AND pas.tipe = 'ri'
                GROUP BY
                    room.ruangan
                ORDER BY
                    room.ruangan ASC
            "), [$periode]
        );

        return response()->json($data);
    }

    public function chartTipePembayaran(Request $req, $periode, $tipe)
    {
        if($tipe != "-") {
            $data = DB::select(
                DB::raw("
                    SELECT
                        byr.tipe_pembayaran, COUNT(pasien.id_pasien) AS jumlah
                    FROM
                        t_tipe_pembayaran byr
                        LEFT JOIN t_pasien pasien ON byr.id_tipe_pembayaran = pasien.id_tipe_pembayaran
                            AND SUBSTR(pasien.tgl_berobat,1,7) = ?
                            AND pasien.tipe = ?
                    GROUP BY
                        byr.tipe_pembayaran
                    ORDER BY
                        byr.tipe_pembayaran ASC
                "), [$periode, $tipe]
            );
    
            return response()->json($data);
        } else {
            $data = DB::select(
                DB::raw("
                    SELECT
                        byr.tipe_pembayaran, COUNT(pasien.id_pasien) AS jumlah
                    FROM
                        t_tipe_pembayaran byr
                        LEFT JOIN t_pasien pasien ON byr.id_tipe_pembayaran = pasien.id_tipe_pembayaran
                            AND SUBSTR(pasien.tgl_berobat,1,7) = ?
                    GROUP BY
                        byr.tipe_pembayaran
                    ORDER BY
                        byr.tipe_pembayaran ASC
                "), [$periode]
            );
    
            return response()->json($data);
        }
    }
}
