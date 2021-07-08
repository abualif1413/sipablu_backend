<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function add(Request $request)
    {
        $gudang = new \App\Models\Gudang();
        $gudang->id_unit = $request->id_unit;
        $gudang->id_status_gudang = $request->id_status_gudang;
        $gudang->nama_gudang = $request->nama_gudang;
        $gudang->alamat_gudang = $request->alamat_gudang;
        $gudang->save();

        return response()->json(["success" => 1, "message" => "Berhasil menambah gudang"]);
    }

    public function update(Request $request)
    {
        $gudang = \App\Models\Gudang::find($request->id_gudang);
        $gudang->id_status_gudang = $request->id_status_gudang;
        $gudang->nama_gudang = $request->nama_gudang;
        $gudang->alamat_gudang = $request->alamat_gudang;
        $gudang->save();

        return response()->json(["success" => 1, "message" => "Berhasil mengubah gudang"]);
    }

    public function delete(Request $request)
    {
        $gudang = \App\Models\Gudang::find($request->id_gudang);
        $gudang->delete();

        return response()->json(["success" => 1, "message" => "Berhasil menghapus gudang"]);
    }

    public function find(Request $request)
    {
        $gudang = \App\Models\Gudang::find($request->id_gudang);

        return response()->json($gudang);
    }

    public function all_by_unit(Request $request)
    {
        $gudang = \App\Models\Gudang::where('id_unit', $request->id_unit)->orderBy('nama_gudang', 'asc')->get();

        return response()->json($gudang);
    }
}
