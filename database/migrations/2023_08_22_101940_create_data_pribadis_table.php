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
        Schema::create('data_pribadis', function (Blueprint $table) {
            $table->id();
            //user id
            $table->foreignIdFor(User::class);
            $table->string('no_ktp', 20);
            $table->string('nisn');
            $table->text('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('ig')->nullable();
            $table->string('facebook')->nullable();
            $table->text('foto')->nullable();
            $table->string('no_hp');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pribadis');
    }
};
