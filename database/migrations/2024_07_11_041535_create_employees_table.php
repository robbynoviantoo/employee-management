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
        Schema::create('employees', function (Blueprint $table) {
            $table->string('nik')->primary()->unique();
            $table->string('name'); 
            $table->string('position');
            $table->string('building');
            $table->string('area');
            $table->string('cell');
            $table->string('idpass');
            $table->bigInteger('phone');
            $table->date('datein');
            $table->date('dateout');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
