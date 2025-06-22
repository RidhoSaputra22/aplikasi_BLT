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
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // contoh: C1, C2
            $table->string('nama_kriteria');
            $table->enum('tipe', ['Benefit', 'Cost']); // Benefit = makin besar makin baik, Cost = makin kecil makin baik
            $table->float('bobot'); // 0.0 - 1.0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriterias');
    }
};
