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
        Schema::create('hasil_psis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calon_penerima_id')->constrained('calon_penerimas')->onDelete('cascade');
            $table->float('nilai_preferensi'); // Hasil total PSI
            $table->string('periode'); // Misal: 2025-Q2
            $table->enum('status', ['Layak', 'Tidak Layak'])->default('Layak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_psis');
    }
};
