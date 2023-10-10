<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tourist_type_tourist_spot', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tourist_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tourist_spot_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_type_tourist_spot');
    }
};
