<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nik');
            $table->string('alasan')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // Tambahkan foreign key yang terhubung ke tabel employees
            $table->foreign('nik')->references('nik')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('absences');
    }
};
