<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Text extends Model
{
    protected $table = "text";
    protected $primaryKey = "id";
    protected $fillable = [
        'judul',
        'deskripsi'
    ];
}
