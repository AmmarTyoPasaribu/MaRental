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
        Schema::table('cars', function (Blueprint $table) {
            $table->string('gambar_public_id')->nullable()->after('gambar');
        });

        Schema::table('drivers', function (Blueprint $table) {
            $table->string('gambar_sim_public_id')->nullable()->after('gambar_sim');
        });

        Schema::table('bayars', function (Blueprint $table) {
            $table->string('bukti_public_id')->nullable()->after('bukti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn('gambar_public_id');
        });

        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn('gambar_sim_public_id');
        });

        Schema::table('bayars', function (Blueprint $table) {
            $table->dropColumn('bukti_public_id');
        });
    }
};
