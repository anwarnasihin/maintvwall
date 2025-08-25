<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class text extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'status'
    ];
}
