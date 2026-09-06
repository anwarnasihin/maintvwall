<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class text extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'status'
    ];

    public function groups()
    {
        return $this->belongsToMany(
            group::class,
            'group_text',
            'text_id',
            'group_id'
        )->withTimestamps();
    }
}
