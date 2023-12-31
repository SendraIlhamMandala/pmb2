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
        Schema::create('tambahans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('survey')->nullable();
            $table->json('isi_data')->nullable();
            $table->text('foto_bukti')->nullable();
            $table->text('pdf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tambahans');
    }
};
