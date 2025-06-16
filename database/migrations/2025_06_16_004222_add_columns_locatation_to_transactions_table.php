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
        Schema::table('transactions', function (Blueprint $table) {
            $table->double('lat');
            $table->double('long');
            $table->unsignedBigInteger('delivery')->nullable();
            $table->foreign('delivery')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('lat');
            $table->dropColumn('long');
            $table->dropForeign('delivery');
            $table->dropColumn('delivery');
        });
    }
};
