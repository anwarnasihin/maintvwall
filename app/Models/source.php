<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Group;
use App\Models\User;

class Source extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'group_id',
        'typeFile',
        'direktori',
        'duration',
        'str_date',
        'ed_date',
        'user_id'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
