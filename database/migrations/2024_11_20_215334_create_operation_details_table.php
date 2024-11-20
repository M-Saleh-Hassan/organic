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
        Schema::create('operation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operation_id')->constrained('operations')->onDelete('cascade');
            $table->enum('type', ['past', 'current', 'future']); // Type of operation
            $table->text('description'); // Detailed description
            $table->integer('order')->default(0); // Order for sorting within the operation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operation_details');
    }
};
