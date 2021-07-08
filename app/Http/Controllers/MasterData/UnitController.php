<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function add(Request $request)
    {
        $unit = new \App\Models\Unit();
        $unit->unit = $request->unit;
        $unit->alamat = $request->alamat;
        $unit->save();

        return response()->json(["success" => 1, "message" => "Berhasil menambah unit"]);
    }

    public function all()
    {
        $unit = \App\Models\Unit::orderBy('unit', 'asc')->get();

        return response()->json($unit);
    }

    public function find(Request $request)
    {
        $unit = \App\Models\Unit::find($request->id_unit);

        return response()->json($unit);
    }

    public function update(Request $request)
    {
        $unit = \App\Models\Unit::find($request->id_unit);
        $unit->unit = $request->unit;
        $unit->alamat = $request->alamat;
        $unit->save();

        return response()->json(["success" => 1, "message" => "Berhasil mengubah unit"]);
    }

    public function delete(Request $request)
    {
        $unit = \App\Models\Unit::find($request->id_unit);
        $unit->delete();

        return response()->json(["success" => 1, "message" => "Berhasil menghapus unit"]);
    }
}
