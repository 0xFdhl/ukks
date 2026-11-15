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
        Schema::create('tb_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor', 15)->unique();
            $table->enum('jenis_kendaraan', ['motor', 'mobil', 'lainnya']);
            $table->string('warna', 30)->nullable();
            $table->string('pemilik')->nullable();
            $table->foreignId('id_user')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_kendaraan');
    }
};
