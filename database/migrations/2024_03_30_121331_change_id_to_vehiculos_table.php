<?php

/* migracion para cambiar el id de vehiculos para que sea autoincrementable*/ 

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
        Schema::table('vehiculos', function (Blueprint $table) {
            //
            $table->integer('id')->autoIncrement(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            //
            $table->integer('id')->autoIncrement(false)->change();
        });
    }
};
