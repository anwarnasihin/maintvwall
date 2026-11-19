<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Display extends Model
{
    use HasFactory;

    protected $fillable = [
        'display_code',
        'display_name',
        'hostname',
        'ip_address',
        'api_token_hash',
        'last_seen_at',
        'last_sync_at',
        'last_sync_version',
        'agent_version',
        'last_error',
        'is_enabled',
        'active_group_id',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
        'last_sync_at' => 'datetime',
        'is_enabled' => 'boolean',
        'active_group_id' => 'integer',
    ];

    public function groups()
    {
        return $this->belongsToMany(
            group::class,
            'display_group',
            'display_id',
            'group_id'
        )->withTimestamps();
    }

    public function activeGroup()
    {
        return $this->belongsTo(\App\Models\group::class, 'active_group_id');
    }
}
