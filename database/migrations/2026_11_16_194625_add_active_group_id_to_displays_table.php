
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('displays', function (Blueprint $table) {
            $table->unsignedBigInteger('active_group_id')
                ->nullable()
                ->after('is_enabled');

            $table->foreign('active_group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('displays', function (Blueprint $table) {
            $table->dropForeign(['active_group_id']);
            $table->dropColumn('active_group_id');
        });
    }
};
