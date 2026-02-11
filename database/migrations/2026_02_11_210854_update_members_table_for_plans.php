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
    Schema::table('members', function (Blueprint $table) {
        // Drop the old text column
        // Note: This will erase existing plan data for members!
        // Since we are in dev, this is okay.
        $table->dropColumn('plan_type');

        // Add the new link to the plans table
        $table->foreignId('plan_id')->nullable()->after('gym_id')->constrained('plans')->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('members', function (Blueprint $table) {
        $table->dropForeign(['plan_id']);
        $table->dropColumn('plan_id');
        $table->string('plan_type')->default('monthly');
    });
}
};
