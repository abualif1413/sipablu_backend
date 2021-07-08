<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function getStatusGudang()
    {
        $status_gudang = \App\Models\StatusGudang::orderBy('urutan', 'asc')->get();

        return response()->json($status_gudang);
    }
}
