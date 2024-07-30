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
    Schema::create('keranjang', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // Kolom user_id untuk mengelola keranjang berdasarkan pengguna
        $table->unsignedBigInteger('produk_id'); // Kolom produk_id untuk mengelola produk
        $table->string('nama_produk');
        $table->integer('jumlah');
        $table->decimal('harga', 8, 2);
        $table->decimal('sub_total', 10, 2);
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key user_id
        $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade'); // Foreign key produk_id
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjangs');
    }
};
