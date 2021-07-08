<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusGudang extends Model
{
    use HasFactory;
    protected $table = "t_status_gudang";
    protected $primaryKey = "id_status_gudang";
    public $timestamps = false;
}
