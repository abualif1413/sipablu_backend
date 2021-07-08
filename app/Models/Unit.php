<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $table = "t_unit";
    protected $primaryKey = "id_unit";
    const CREATED_AT = 'change_date';
    const UPDATED_AT = 'change_date';
}
