<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserContactTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('user_contacts');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('user_contacts', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->uuid('contacts_id');
            $table->uuid('users_id')->index('user_contacts_users_id');
            $table->uuid('user_connections_id')->index('user_contacts_user_connections_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::table('user_contacts', function (Blueprint $table) {
            $table->foreign('contacts_id')->references('id')->on('users');
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('user_connections_id')
                ->references('id')
                ->on('user_connections')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
}
