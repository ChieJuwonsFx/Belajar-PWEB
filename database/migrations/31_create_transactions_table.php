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
            $table->string('id')->primary();
            $table->enum('transaction_type', ["Online","Offline"])->default("Online");
            $table->string('transaction_code');
            $table->integer('total_jual');
            $table->integer('total_modal');
            $table->string('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('admin_id');
            $table->foreign('admin_id')->references('id')->on('users');
            $table->string('customer_offline')->nullable();
            $table->enum('status', ["Paid","Pending","Canceled"])->default("Pending");
            $table->timestamps();
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
