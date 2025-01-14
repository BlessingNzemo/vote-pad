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
        Schema::table('intervenants', function (Blueprint $table) {
            $table->string('universite')->after('email')->nullable();
            $table->string('statut')->after('universite')->nullable();
            $table->string('promotion')->after('statut')->nullable();
            $table->integer('age')->after('promotion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('intervenants', function (Blueprint $table) {
            //
        });
    }
};
