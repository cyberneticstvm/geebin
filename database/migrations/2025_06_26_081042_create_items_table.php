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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25)->unique();
            $table->unsignedBigInteger('type')->nullable();
            $table->foreign('type')->references('id')->on('extras')->onDelete('cascade');
            $table->unsignedBigInteger('unit');
            $table->foreign('unit')->references('id')->on('extras')->onDelete('cascade');
            $table->integer('two_bin_parts_qty')->nullable();
            $table->integer('three_bin_parts_qty')->nullable();
            $table->string('ppcp_qty_for_one', 10)->nullable();
            $table->string('color_qty_for_one', 10)->nullable();
            $table->string('total_qty_for_one', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
