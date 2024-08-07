<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_new_comers', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable();
            $table->string('component')->nullable();
            $table->text('introduction')->nullable();
            $table->text('cutting')->nullable();
            $table->text('stitching')->nullable();
            $table->text('assembly')->nullable();
            $table->text('second_process')->nullable();
            $table->text('report')->nullable();
            $table->text('six_and_nine_checkpoint')->nullable();
            $table->timestamps();

            $table->foreign('nik')->references('nik')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_new_comers');
    }
};