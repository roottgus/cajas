<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsernameToUsersTable extends Migration
{
    /**
     * Run the migrations.
     * Only adds the column if it doesn't already exist.
     *
     * @return void
     */
    public function up()
    {
        // Check that column doesn't already exist
        if (! Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')
                      ->nullable()
                      ->unique()
                      ->after('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     * Drops the column and index only if it exists.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['username']);
                $table->dropColumn('username');
            });
        }
    }
}
