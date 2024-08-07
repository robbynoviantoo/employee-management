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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->unsignedBigInteger('materi_id');
            $table->date('tanggal')->nullable();
            $table->decimal('first_score', 5, 2)->nullable();
            $table->decimal('retest_score', 5, 2)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('nik')->references('nik')->on('employees')->onDelete('cascade');
            $table->foreign('materi_id')->references('id')->on('materis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainings');
    }
};
