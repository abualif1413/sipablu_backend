<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    use HasFactory;
    protected $table = "t_gudang";
    protected $primaryKey = "id_gudang";
    const CREATED_AT = 'change_date';
    const UPDATED_AT = 'change_date';
}
