<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterisTable extends Migration
{
    public function up()
    {
        Schema::create('materis', function (Blueprint $table) {
            $table->id();
            $table->string('materi_name');
            $table->string('kategori');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materis');
    }
}