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
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('subcontractor_id');
            $table->foreignId('floor_plan_id')->nullable()->constrained('floor_plans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->bigInteger('subcontractor_id')->nullable();
            $table->dropForeign(['floor_plan_id']);
            $table->dropColumn('floor_plan_id');
        });
    }
};
