<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokPengguna extends Model
{
    use HasFactory;
    protected $table = "KelompokPengguna";
    protected $primaryKey = "idKelompokPengguna";
    const CREATED_AT = 'changeTime';
    const UPDATED_AT = 'changeTime';
}
