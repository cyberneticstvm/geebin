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
            $table->date('date');
            $table->enum('item', ['product', 'material', 'parts'])->nullable();
            $table->unsignedBigInteger('from_company_id');
            $table->foreign('from_company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('to_company_id');
            $table->foreign('to_company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->enum('approved_status', ['pending', 'approved', 'rejected'])->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();
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
