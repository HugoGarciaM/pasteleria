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
        Schema::table('detail_pays', function (Blueprint $table) {
            $table->dropColumn('token');
            $table->integer('status')->nullable(true)->after('qr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_pays', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->string('token')->nullable(false);
        });
    }
};
