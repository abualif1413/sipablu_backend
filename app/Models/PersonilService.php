<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonilService extends Model
{
    use HasFactory;
    protected $table = "t_personil_service";
    protected $primaryKey = "id_personil_service";
}
