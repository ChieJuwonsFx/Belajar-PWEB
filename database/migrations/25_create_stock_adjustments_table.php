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
        Schema::disableForeignKeyConstraints();

        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('quantity');
            $table->enum('alasan', ["Rusak","Hilang","Expired","Diretur"]);
            $table->text('note')->nullable();
            $table->string('stock_id');
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->string('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
    }
};
