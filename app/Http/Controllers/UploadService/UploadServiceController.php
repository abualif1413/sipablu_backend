<?php

namespace App\Http\Controllers\UploadService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadServiceController extends Controller
{
    public function newFile(Request $req)
    {
        $file = $req->file('berkas');
        $extension = $file->getClientOriginalExtension();

        if(strtolower($extension) == "pdf") {
            $user = \App\Http\Controllers\MasterData\UserController::breakToken($req->bearerToken());
    
            $data_upload = new \App\Models\DataUpload;
            $data_upload->tipe = $req->tipe;
            $data_upload->judul = $req->judul;
            $data_upload->tanggal = $req->tanggal;
            $data_upload->author = $req->author;
            $data_upload->keterangan = $req->keterangan;
            $data_upload->created_by = $user->id;
            $data_upload->save();
    
            $id_data_upload = $data_upload->id_data_upload;
    
            $file_name = md5($id_data_upload) . ".pdf";
            $destination_path = \public_path() . "/uploads";
            $file->move($destination_path, $file_name);
            
            return response()->json(["success" => 1, "message" => "Selesai"]);
        } else {
            return response()->json(["success" => 0, "message" => "Jenis file yang diijinkan hanya PDF"], 422);
        }
    }

    public function updateFile(Request $req)
    {
        $user = \App\Http\Controllers\MasterData\UserController::breakToken($req->bearerToken());

        $data_upload = \App\Models\DataUpload::find($req->id_data_upload);
        $data_upload->judul = $req->judul;
        $data_upload->tanggal = $req->tanggal;
        $data_upload->author = $req->author;
        $data_upload->keterangan = $req->keterangan;
        $data_upload->updated_by = $user->id;
        $data_upload->save();

        $id_data_upload = $data_upload->id_data_upload;

        if($req->file("berkas")) {
            $file = $req->file('berkas');
            $extension = $file->getClientOriginalExtension();

            if(strtolower($extension) == "pdf") {
                $file_name = md5($id_data_upload) . ".pdf";
                $destination_path = \public_path() . "/uploads";
                File::delete($destination_path . "/" . $file_name);
                $file->move($destination_path, $file_name);
            }
        }
        
        return response()->json(["success" => 1, "message" => "Selesai"]);
    }

    public function getDataUpload(Request $req, $tipe)
    {
        $data_upload = \App\Models\DataUpload::where('tipe', $tipe)->whereBetween('tanggal', [$req->dari, $req->sampai])->orderBy('updated_at', 'desc')->paginate(15);

        foreach ($data_upload as &$du) {
            $du->nama_file = md5($du->id_data_upload) . ".pdf";
        }

        return response()->json($data_upload);
    }

    public function findDataUpload($id_data_upload)
    {
        $data_upload = \App\Models\DataUpload::find($id_data_upload);
        $data_upload->nama_file = md5($data_upload->id_data_upload) . ".pdf";

        return response()->json($data_upload);
    }

    public function deleteDataUpload($id_data_upload)
    {
        $data_upload = \App\Models\DataUpload::find($id_data_upload);
        $nama_file = md5($data_upload->id_data_upload) . ".pdf";
        $destination_path = \public_path() . "/uploads";
        File::delete($destination_path . "/" . $nama_file);
        $data_upload->delete();

        return response()->json(["success" => 1]);
    }

    public function getService(Request $req, $tipe) {
        $upsvc = \App\Models\UploadService::where('tipe', $tipe)->first();

        return response()->json($upsvc);
    }
}
