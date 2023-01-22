<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'wisata_id', 'attach_name'
    ];
}
