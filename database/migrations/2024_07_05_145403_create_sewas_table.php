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
        Schema::create('sewas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            // $table->unsignedBigInteger('produk_id');
            $table->string('bukti_identitas');
            $table->date('tanggal_sewa');
            $table->date('tanggal_pengembalian');            
            $table->decimal('total_harga', 15, 2);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewas');
    }
};
