<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadService extends Model
{
    use HasFactory;
    protected $table = "t_upload_service";
    protected $primaryKey = "id_upload_service";
}
