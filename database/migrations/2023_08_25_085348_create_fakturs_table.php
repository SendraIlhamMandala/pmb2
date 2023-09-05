<?php

use App\Models\User;
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
        Schema::create('fakturs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('no_rekening');
            $table->boolean('pakai_voucher');
            $table->date('tanggal_bayar');
            $table->integer('jumlah_bayar');
            $table->text('foto_bukti')->nullable();
            $table->boolean('validasi')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fakturs');
    }
};
