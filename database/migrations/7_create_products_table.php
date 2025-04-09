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
            $table->id();
            $table->string('name');
            $table->text('deskripsi');
            $table->integer('harga_jual');
            $table->integer('stok');
            $table->integer('stok_minimum');
            $table->json('image');
            $table->enum('is_available', ["Active","Inactive"])->default("Active");
            $table->bigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->dateTime('created_at');
            $table->datetime('updated_at')->nullable();
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
