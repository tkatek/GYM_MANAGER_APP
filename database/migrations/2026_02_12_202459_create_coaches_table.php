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
    Schema::create('coaches', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('specialty'); // e.g., Bodybuilding, Yoga, Crossfit
        $table->string('phone');
        $table->string('photo')->nullable(); // For the profile picture
        $table->decimal('session_price', 8, 2); // How much they charge per session
        $table->text('planning')->nullable(); // To store their weekly schedule
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaches');
    }
};
