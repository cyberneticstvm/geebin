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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->decimal('qty', 10, 2)->default(0.0);
            $table->unsignedBigInteger('entity_id');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->text('purchase_note')->nullable();
            $table->unsignedBigInteger('closed_by')->nullable();
            $table->foreign('closed_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('closed_at')->nullable();
            $table->text('closed_note')->nullable();
            $table->unsignedBigInteger('status');
            $table->foreign('status')->references('id')->on('extras')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
