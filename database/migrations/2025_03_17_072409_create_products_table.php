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

        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('deskripsi');
            $table->integer('harga_jual');
            $table->integer('stok');
            $table->integer('stok_minimum');
            $table->json('image');
            $table->enum('is_available', ["Active","Inactive"]);
            $table->bigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('category');
            $table->dateTime('created_at');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
