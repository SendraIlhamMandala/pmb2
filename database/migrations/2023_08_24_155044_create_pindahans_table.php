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
        Schema::create('pindahans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('perguruan_tinggi');
            $table->string('program_studi');
            $table->string('nomor_induk_mahasiswa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pindahans');
    }
};
