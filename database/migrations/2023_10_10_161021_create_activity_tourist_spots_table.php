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
        Schema::create('activity_tourist_spots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tourist_spot_id')->constrained()->cascadeOnDelete();

            $table->text('remarks')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_tourist_spots');
    }
};
