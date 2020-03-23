<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->uuid('message_thread_id');
            $table->longText('message');
            $table->uuid('receiver_id');
            $table->uuid('sender_id');
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('message_thread_id')
                ->references('id')
                ->on('message_threads')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
}
