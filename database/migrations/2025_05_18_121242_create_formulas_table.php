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
        Schema::create('formulas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('part_id');
            $table->unsignedBigInteger('bin_id');
            $table->string('part_name', 25)->nullable();
            $table->string('bin_name', 25)->nullable();
            $table->string('ppcp', 10)->default(0.0);
            $table->string('color', 10)->default(0.0);
            $table->string('material', 5)->comment("Total material both (color and ppc) requiered to produce a whole bin (ppcp + color * qty)")->default(0.0);
            $table->integer('qty')->comment("Parts output qty to produce a whole bin")->default(0.0);
            $table->foreign('part_id')->references('id')->on('extras')->onDelete('cascade');
            $table->foreign('bin_id')->references('id')->on('extras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulas');
    }
};
