<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserConnectionsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('user_connections');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('user_connections', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->uuid('inviter_id');
            $table->uuid('invitee_id');
            $table->string('status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::table('user_connections', function (Blueprint $table) {
            $table->foreign('inviter_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('invitee_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
