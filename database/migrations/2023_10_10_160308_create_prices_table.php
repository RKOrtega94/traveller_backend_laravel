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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tourist_spot_id')->constrained()->cascadeOnDelete();

            $table->enum('label', ['adult', 'child', 'senior', 'student', 'infant'])->default('adult');
            $table->enum('type', ['local', 'foreign'])->default('local');

            $table->text('remarks')->nullable();

            $table->decimal('price', 8, 2);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
