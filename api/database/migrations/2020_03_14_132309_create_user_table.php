<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->uuid('groups_id');
            $table->string('first_name', 32);
            $table->string('last_name', 32);
            $table->string('address', 190);
            $table->string('city', 190);
            $table->string('zip', 6);
            $table->string('country', 32);
            $table->string('email', 32)->index('user_email');
            $table->string('phone', 13);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('groups_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }
}
