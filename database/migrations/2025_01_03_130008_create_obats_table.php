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
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_obats', 'id')->cascadeOnDelete();
            $table->string('nama_singkat');
            $table->string('nama_obat');
            $table->string('indikasi');
            $table->text('keterangan_obat');
            $table->integer('stok_obat');
            $table->date('kadaluarsa');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
