<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiUmum extends Model
{
    use HasFactory;
    protected $table = "t_informasi_rumah_sakit";
    protected $primaryKey = "id_informasi_rumah_sakit";
}
