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
        Schema::create('product_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('date_id')->nullable(false);
            $table->unsignedBigInteger('product_id')->nullable(false);
            $table->integer('quantity')->nullable(false);

            $table->foreign('date_id')->references('id')->on('dates');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_days');
    }
};
