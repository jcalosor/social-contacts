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
            $table->uuid('groups_id');
            $table->uuid('users_id')->index('user_contacts_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::table('user_contacts', function (Blueprint $table) {
            $table->foreign('contacts_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('groups_id')->references('id')->on('groups')->onUpdate('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

        });
    }
}
