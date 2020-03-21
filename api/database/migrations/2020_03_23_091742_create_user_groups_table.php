<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGroupsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('user_groups');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('user_groups', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->uuid('user_contacts_id');
            $table->uuid('groups_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::table('user_groups', function (Blueprint $table) {
            $table->foreign('user_contacts_id')
                ->references('id')
                ->on('user_contacts')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('groups_id')
                ->references('id')
                ->on('groups')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
}
