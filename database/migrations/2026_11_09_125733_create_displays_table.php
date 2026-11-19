
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisplaysTable extends Migration
{
    public function up()
    {
        Schema::create('displays', function (Blueprint $table) {
            $table->id();

            $table->string('display_code', 100)->unique();
            $table->string('display_name', 150);
            $table->string('hostname', 150)->nullable();
            $table->string('ip_address', 45)->nullable();

            $table->char('api_token_hash', 64)->unique();

            $table->dateTime('last_seen_at')->nullable();
            $table->dateTime('last_sync_at')->nullable();

            $table->string('last_sync_version', 100)->nullable();
            $table->string('agent_version', 30)->nullable();
            $table->text('last_error')->nullable();

            $table->boolean('is_enabled')->default(true);

            $table->timestamps();

            $table->index('last_seen_at');
            $table->index('is_enabled');
        });
    }

    public function down()
    {
        Schema::dropIfExists('displays');
    }
}
