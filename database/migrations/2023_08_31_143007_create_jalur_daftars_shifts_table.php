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
        Schema::create('jalur_daftars_shifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('jalur_daftars_id')->unsigned();
            $table->unsignedBiginteger('shifts_id')->unsigned();

            $table->foreign('jalur_daftars_id')->references('id')
                 ->on('jalur_daftars')->onDelete('cascade');
            $table->foreign('shifts_id')->references('id')
                ->on('shifts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jalur_daftars_shifts');
    }
};
