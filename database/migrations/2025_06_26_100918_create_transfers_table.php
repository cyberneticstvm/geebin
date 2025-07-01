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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->date('transfer_date');
            $table->unsignedBigInteger('from_entity');
            $table->foreign('from_entity')->references('id')->on('entities')->onDelete('cascade');
            $table->unsignedBigInteger('to_entity');
            $table->foreign('to_entity')->references('id')->on('entities')->onDelete('cascade');
            $table->text('transfer_note')->nullable();
            $table->unsignedBigInteger('status');
            $table->foreign('status')->references('id')->on('extras')->onDelete('cascade');
            $table->unsignedBigInteger('status_updated_by')->nullable();
            $table->foreign('status_updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('status_updated_at')->nullable();
            $table->text('status_note')->nullable();
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
        Schema::dropIfExists('transfers');
    }
};
