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
    Schema::create('members', function (Blueprint $table) {
        $table->id();
        // This links the member to a specific gym (Multi-tenancy)
        $table->foreignId('gym_id')->constrained('gyms')->onDelete('cascade');
        
        $table->string('name');
        $table->string('phone')->nullable();
        
        // Plan details
        $table->enum('plan_type', ['monthly', '3_months', 'yearly']);
        $table->decimal('price', 8, 2); // e.g., 50.00
        
        // Subscription Status
        $table->date('start_date');
        $table->date('end_date');
        $table->enum('status', ['active', 'expired'])->default('active');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
