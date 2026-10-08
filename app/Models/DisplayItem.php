<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisplayItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'playlist_id',
        'source_id',
        'position',
    ];

    /**
     * Item ini milik satu playlist.
     */
    public function playlist()
    {
        return $this->belongsTo(DisplayPlaylist::class, 'playlist_id', 'id');
    }

    /**
     * Item ini mengarah ke satu source/content.
     */
    public function source()
    {
        return $this->belongsTo(source::class, 'source_id', 'id');
    }
}
