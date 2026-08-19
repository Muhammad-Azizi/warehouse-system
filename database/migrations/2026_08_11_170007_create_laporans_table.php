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
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            $table->string('nomor_laporan')->unique();

            $table->date('tanggal');

            $table->string('jenis_laporan');

            $table->string('keterangan')->nullable();

            $table->integer('total_item')->default(0);

            $table->decimal('total_qty', 15, 2)->default(0);

            $table->string('status')->default('Selesai');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};