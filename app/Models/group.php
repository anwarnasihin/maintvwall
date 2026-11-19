<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'keterangan'
    ];

    public function texts()
    {
        return $this->belongsToMany(
            text::class,
            'group_text',
            'group_id',
            'text_id'
        )->withTimestamps();
    }

    public function displays()
    {
        return $this->belongsToMany(
            Display::class,
            'display_group',
            'group_id',
            'display_id'
        )->withTimestamps();
    }



}
