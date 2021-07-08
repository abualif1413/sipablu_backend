<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataUpload extends Model
{
    use HasFactory;
    protected $table = "t_data_upload";
    protected $primaryKey = "id_data_upload";
}
