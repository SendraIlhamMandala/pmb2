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
        Schema::create('asal_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('nama_sekolah');
            $table->string('alamat_sekolah', 255);
            $table->string('tahun_lulus');
            $table->string('jurusan');
            $table->string('nilai_skhun');
            $table->text('skhun');
            $table->text('ijazah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asal_sekolahs');
    }
};
