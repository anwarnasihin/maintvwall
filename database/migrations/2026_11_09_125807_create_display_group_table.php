
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisplayGroupTable extends Migration
{
    public function up()
    {
        Schema::create('display_group', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('display_id');
            $table->unsignedBigInteger('group_id');

            $table->timestamps();

            $table->foreign('display_id')
                ->references('id')
                ->on('displays')
                ->onDelete('cascade');

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('restrict');

            $table->unique(['display_id', 'group_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('display_group');
    }
}
