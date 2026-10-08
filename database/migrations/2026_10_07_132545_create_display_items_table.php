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
        Schema::create('display_items', function (Blueprint $table) {
            $table->id();

            // Playlist yang memiliki item ini
            $table->foreignId('playlist_id')
                ->constrained('display_playlists')
                ->cascadeOnDelete();

            // Source/content yang akan ditampilkan
            $table->foreignId('source_id')
                ->constrained('sources')
                ->cascadeOnDelete();

            // Urutan tampil di slideshow
            $table->unsignedInteger('position');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('display_items');
    }
};
