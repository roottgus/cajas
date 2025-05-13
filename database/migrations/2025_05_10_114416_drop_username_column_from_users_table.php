<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUsernameColumnFromUsersTable extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                // Basta con eliminar la columna; el índice se elimina automáticamente
                $table->dropColumn('username');
            });
        }
    }

    public function down()
    {
        if (! Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                // Para revertir volvemos a crear la columna nullable y única
                $table->string('username')->nullable()->unique()->after('email');
            });
        }
    }
}
