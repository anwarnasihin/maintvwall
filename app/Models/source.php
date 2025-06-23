<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class source extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'group',
        'typeFile',
        'direktori',
        'duration',
        'str_date',
        'ed_date',
        'users'
    ];

    public function groups()
    {
        return $this->belongsTo(group::class, 'group', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users', 'id');
    }
}
