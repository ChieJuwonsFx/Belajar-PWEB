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

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('transaction_type', ["Online","Offline"]);
            $table->string('transaction_code');
            $table->integer('total_jual');
            $table->integer('total_modal');
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('users');
            $table->enum('status', ["Paid","Pending","Canceled"]);
            $table->timestamp('created_at');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
