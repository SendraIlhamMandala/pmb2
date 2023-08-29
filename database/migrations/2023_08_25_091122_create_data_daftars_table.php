<?php

use App\Models\Tahun;
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
        Schema::create('data_daftars', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('shift')->default('-');
            $table->string('jalur')->default('-');
            $table->string('status')->default('-');
            $table->string('program_studi')->default('-');
            $table->foreignIdFor(Tahun::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_daftars');
    }
};
