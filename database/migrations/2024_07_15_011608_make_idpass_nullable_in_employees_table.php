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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('idpass', 255)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Isi nilai null dengan nilai default sebelum mengubah kolom menjadi nullable(false)
            \Illuminate\Support\Facades\DB::table('employees')->whereNull('idpass')->update(['idpass' => 'default_value']);

            $table->string('idpass', 255)->nullable(false)->change();
        });
    }
};