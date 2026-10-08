<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('display_playlists', function (Blueprint $table) {
            $table->id();

            // Playlist ini milik group tertentu
            $table->foreignId('group_id')
                ->constrained('groups')
                ->cascadeOnDelete();

            // Nama playlist
            $table->string('name')->default('Default Playlist');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('display_playlists');
    }
};
