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

        Schema::create('transaction_items', function (Blueprint $table) {
            $table->id();
            $table->integer('subtotal');
            $table->integer('quantity');
            $table->bigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('harga_modal');
            $table->integer('harga_jual');
            $table->bigInteger('stock_id');
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->bigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_items');
    }
};
