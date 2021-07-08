<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienService extends Model
{
    use HasFactory;
    protected $table = "t_pasien_service";
    protected $primaryKey = "id_pasien_service";
}
