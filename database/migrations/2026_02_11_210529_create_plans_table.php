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
    Schema::create('plans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('gym_id')->constrained('gyms')->onDelete('cascade'); // Links plan to the Gym
        $table->string('name');           // e.g., "Gold Membership"
        $table->integer('duration_days'); // e.g., 30
        $table->decimal('price', 8, 2);   // e.g., 50.00
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
