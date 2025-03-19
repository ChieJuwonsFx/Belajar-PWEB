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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('stok');
            $table->integer('harga');
            $table->text('deskripsi');
            $table->text('komposisi');
            $table->string('rasa');
            $table->integer('berat');
            $table->enum('status', ['Active', 'Inactive']);
            $table->json('image')->nullable();
            $table->foreignId('category_id')->constrained(
                table : 'categories',
                indexName : 'products_category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
