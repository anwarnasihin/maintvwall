<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    // 🔴 PERBAIKAN DI SINI: Masukkan 'user_id' dan 'activity' ke dalam array
    protected $fillable = ['user_id', 'activity'];

    // Relasi ke User tetap biarkan seperti ini
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
