<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToBoxTransactions extends Migration
{
    public function up()
    {
        Schema::table('box_transactions', function (Blueprint $table) {
            $table->softDeletes(); // esto añade deleted_at TIMESTAMP NULL
        });
    }

    public function down()
    {
        Schema::table('box_transactions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
