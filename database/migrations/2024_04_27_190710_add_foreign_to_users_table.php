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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('person_ci')->references('ci')->on('persons');
        });

        Schema::table('transactions',function(Blueprint $table){
            $table->foreign('customer')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('customer');
        });
    }
};
