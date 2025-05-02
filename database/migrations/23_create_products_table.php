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

        Schema::create('products', function (Blueprint $table) {
            $table->string('id')->primary();  
            $table->string('barcode')->nullable()->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->integer('harga_jual');
            $table->integer('stok_minimum');
            $table->integer('stok');
            $table->json('image');
            $table->enum('is_available', ["Available", "Unavailable"])->default("Available");
            $table->boolean('is_active')->default(true);
            $table->boolean('is_stock_real')->default(true);
            $table->boolean('is_modal_real')->default(true);
            $table->integer('estimasi_modal')->nullable();
            $table->string('category_id'); 
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('unit_id');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->timestamps();
        });
        

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
