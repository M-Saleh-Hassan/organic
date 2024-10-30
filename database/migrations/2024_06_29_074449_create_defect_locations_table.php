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
        Schema::create('defect_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('defect_id')->constrained('defects')->onDelete('cascade');
            $table->double('horizontal');
            $table->double('vertical');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defect_locations');
    }
};
