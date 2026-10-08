<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisplayPlaylist extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'name',
    ];

    /**
     * Playlist ini milik satu Group.
     */
    public function group()
    {
        return $this->belongsTo(group::class, 'group_id', 'id');
    }

    /**
     * Playlist memiliki banyak item.
     */
    public function items()
    {
        return $this->hasMany(DisplayItem::class, 'playlist_id', 'id')
            ->orderBy('position');
    }
}
