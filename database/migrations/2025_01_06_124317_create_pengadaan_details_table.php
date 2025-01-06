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
        Schema::create('pengadaan_details', function (Blueprint $table) {
            $table->id();
            $table->string('nota_pengadaan');
            $table->foreignId('obat_id');
            $table->foreign('nota_pengadaan')->references('nota_pengadaan')->on('pengadaans')->cascadeOnDelete();
            $table->string('satuan');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan_details');
    }
};
