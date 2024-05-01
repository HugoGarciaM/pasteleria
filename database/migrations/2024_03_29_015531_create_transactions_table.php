<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer')->nullable(false);
            $table->unsignedBigInteger('seller')->nullable(false);
            $table->integer('status')->nullable(false);
            $table->integer('type')->nullable(false);
            $table->unsignedBigInteger('detail_pay_id');
            $table->timestamps();

            $table->foreign('seller')->references('id')->on('users');
            $table->foreign('detail_pay_id')->references('id')->on('detail_pays');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
