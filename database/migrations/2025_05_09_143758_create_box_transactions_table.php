<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('box_transactions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('vendor_id')->constrained('users');
    $table->foreignId('admin_id')->constrained('users');
    $table->enum('type', ['issue','return']);
    $table->unsignedInteger('quantity');
    $table->text('notes')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('box_transactions');
    }
};
