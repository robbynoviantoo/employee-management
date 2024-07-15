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
        Schema::table('employees', function (Blueprint $table) {
            $table->date('dateout')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Perbarui nilai null menjadi nilai default sebelum mengubah kolom
            \Illuminate\Support\Facades\DB::table('employees')->whereNull('dateout')->update(['dateout' => '1970-01-01']);

            // Ubah kolom menjadi nullable(false)
            $table->date('dateout')->nullable(false)->change();
        });
    }
};
