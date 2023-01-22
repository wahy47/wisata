<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'nama_wisata', 'maps', 'deskripsi', 'foto', 'qr_code'
    ];
}
