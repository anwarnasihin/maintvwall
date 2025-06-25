<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->json('selected_days')->nullable()->after('ed_date'); // Menyimpan JSON hari yang dipilih
        });
    }

    public function down()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->dropColumn('selected_days');
        });
    }

};
