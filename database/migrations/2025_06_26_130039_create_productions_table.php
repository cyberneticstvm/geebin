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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->date('production_date');
            $table->unsignedBigInteger('from_entity');
            $table->foreign('from_entity')->references('id')->on('entities')->onDelete('cascade');
            $table->unsignedBigInteger('to_entity');
            $table->foreign('to_entity')->references('id')->on('entities')->onDelete('cascade');
            $table->text('production_note')->nullable();
            $table->unsignedBigInteger('type');
            $table->foreign('type')->references('id')->on('extras')->onDelete('cascade');
            $table->integer('sub_type')->comment('Two types for Decom Production -> Liquid & Powder(2) and Powder(1)')->default(0);
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->foreign('closed_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('closed_at')->nullable();
            $table->text('closed_note')->nullable();
            $table->unsignedBigInteger('status');
            $table->foreign('status')->references('id')->on('extras')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
