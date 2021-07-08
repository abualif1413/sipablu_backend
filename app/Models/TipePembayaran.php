<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipePembayaran extends Model
{
    use HasFactory;
    protected $table = "t_tipe_pembayaran";
    protected $primaryKey = "id_tipe_pembayaran";
}
