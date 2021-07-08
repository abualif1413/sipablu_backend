<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function add(Request $req)
    {
        $kelompokPengguna = new \App\Models\KelompokPengguna();
        $kelompokPengguna->kelompokPengguna = $req->kelompok;
        $kelompokPengguna->keterangan = $req->keterangan;
        $kelompokPengguna->save();

        return response()->json(["success" => 1]);
    }

    public function edit(Request $req)
    {
        $kelompokPengguna = \App\Models\KelompokPengguna::find($req->id);
        $kelompokPengguna->kelompokPengguna = $req->kelompok;
        $kelompokPengguna->keterangan = $req->keterangan;
        $kelompokPengguna->save();

        return response()->json(["success" => 1]);
    }

    public function delete(Request $req)
    {
        $kelompokPengguna = \App\Models\KelompokPengguna::find($req->id);
        $kelompokPengguna->delete();

        return response()->json(["success" => 1]);
    }

    public function all()
    {
        $kelompokPengguna = \App\Models\KelompokPEngguna::orderBy('kelompokPengguna')->get();

        return response()->json($kelompokPengguna);
    }

    public function find($idKelompokPengguna)
    {
        $kelompokPengguna = \App\Models\KelompokPengguna::find($idKelompokPengguna);

        return response()->json($kelompokPengguna);
    }

    public function addUser(Request $req)
    {
        // validating input
        $usrCek = \App\Models\User::where('email', $req->email)->get();
        if($req->email == "" || $req->name == "" || $req->password == "" || $req->password2 == "" || $req->idKelompokPengguna == "") {
            return response()->json(["success" => 0, "message" => "Nama, email, tipe user, password, dan ulangi password harap diinput"], 422);
        } elseif($req->password != $req->password2) {
            return response()->json(["success" => 0, "message" => "Password dan ulangi password tidak sama"], 422);
        } elseif(count($usrCek) > 0) {
            return response()->json(["success" => 0, "message" => "Email " . $req->email . " sudah digunakan. Harap ganti dengan yang lain"], 422);
        } else {
            $user = new \App\Models\User();
            $user->name = $req->name;
            $user->email = $req->email;
            $user->password = Hash::make($req->password);
            $user->idKelompokPengguna = $req->idKelompokPengguna;
            $user->save();
    
            return response()->json(["success" => 1]);
        }
    }

    public function findUser(Request $req)
    {
        $dec = Crypt::decryptString($req->id);
        $user = \App\Models\User::find($dec);

        return response()->json($user);
    }

    public function editUser(Request $req)
    {
        $dec = Crypt::decryptString($req->id);

        // validating input
        $usrCek = \App\Models\User::where('email', $req->email)->where('id', '<>', $dec)->get();
        if($req->email == "" || $req->name == "" || $req->idKelompokPengguna == "") {
            return response()->json(["success" => 0, "message" => "Nama, email, dan tipe user harap diinput"], 422);
        } elseif(count($usrCek) > 0) {
            return response()->json(["success" => 0, "message" => "Email " . $req->email . " sudah digunakan. Harap ganti dengan yang lain"], 422);
        } else {
            $user = \App\Models\User::find($dec);
            $user->name = $req->name;
            $user->email = $req->email;
            $user->idKelompokPengguna = $req->idKelompokPengguna;
            $user->save();
    
            return response()->json(["success" => 1]);
        }
    }

    public function editPassword(Request $req)
    {
        if($req->password == "" || $req->password2 == "") {
            return response()->json(["success" => 0, "message" => "Password dan ulangi password harap diinput"], 422);
        } elseif($req->password != $req->password2) {
            return response()->json(["success" => 0, "message" => "Password dan ulangi password tidak sama"], 422);
        } else {
            $dec = Crypt::decryptString($req->id);
            $user = \App\Models\User::find($dec);
            $user->password = Hash::make($req->password);
            $user->save();
    
            return response()->json(["success" => 1]);
        }
    }

    public function listUserByKelompok(Request $req)
    {
        $user = [];
        if($req->idKelompokPengguna != 0)
            $user = \App\Models\User::where('idKelompokPengguna', $req->idKelompokPengguna)
                        ->where(function($query) use ($req) {
                            $query->where('name', 'like', '%' . $req->search . '%')
                            ->orWhere('email', 'like', '%' . $req->search . '%');
                        })
                        ->orderBy('email', 'asc')->get();
        else
            $user = \App\Models\User::orderBy('email', 'asc')
                        ->where(function($query) use ($req) {
                            $query->where('name', 'like', '%' . $req->search . '%')
                            ->orWhere('email', 'like', '%' . $req->search . '%');
                        })
                        ->get();
        
        foreach ($user as &$usr) {
            $usr->enc_id = Crypt::encryptString($usr->id);
        }

        return response()->json($user);
    }

    public static function breakToken($token) {
        if(!$token)
            return null;

        try {
            //code...
            $dec_token = Crypt::decryptString($token);
            $arr_token = json_decode($dec_token, true);
            $user = \App\Models\User::where('id', $arr_token["id"])->where('email', $arr_token["email"])->first();
    
            return $user;
        } catch (Exception $ex) {
            return null;
        }
    }

    public function loginAttempt(Request $req)
    {
        $user = \App\Models\User::where('email', $req->email)->first();
        if($user) {
            $password = $user->password;
            if(password_verify($req->password, $password)) {
                // Generate hash id user untuk dikirim sebagai key di aplikasi
                $arr_token = ["id" => $user->id, "email" => $user->email];
                $token = Crypt::encryptString(json_encode($arr_token));
                
                return response()->json(["success" => 1, "message" => "Login berhasil", "token" => $token]);
            } else {
                return response()->json(["success" => 0, "message" => "Password yang dimasukkan salah"], 422);    
            }
        } else {
            return response()->json(["success" => 0, "message" => "Username / email tidak ditemukan"], 422);
        }
    }

    public function findAuthUser(Request $req)
    {
        $token = $req->bearerToken();
        $user = self::breakToken($token);

        if($user)
            return response()->json($user);
        else
            return response()->json(["success" => 0, "message" => "Unauthorized user has detected"], 422);
    }
}
