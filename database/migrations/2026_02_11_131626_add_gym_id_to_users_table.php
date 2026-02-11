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
    Schema::table('users', function (Blueprint $table) {
        // We make it nullable first so it doesn't break existing seeds, 
        // but for the app it will be required.
        $table->foreignId('gym_id')->nullable()->after('id')->constrained('gyms')->onDelete('cascade');
        $table->string('role')->default('owner')->after('email');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['gym_id']);
        $table->dropColumn(['gym_id', 'role']);
    });
}
};
