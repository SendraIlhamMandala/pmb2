<?php

use App\Models\Shift;
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
        Schema::create('tahuns', function (Blueprint $table) {
            $table->id();
            $table->string('gelombang');
            $table->string('tahun');
            $table->string('status');
            $table->string('no_utama')->unique();
            $table->date('daritgl');
            $table->date('sampaitgl');

            $table->timestamps();
            //foreign data daftar


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahuns');
    }
};
