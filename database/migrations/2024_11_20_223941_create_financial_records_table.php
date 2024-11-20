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
        Schema::create('financial_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_id')->constrained('financials')->onDelete('cascade');
            $table->string('month')->nullable(); // Month as a string (e.g., "March")
            $table->date('date')->nullable(); // Full date for the financial record
            $table->decimal('amount', 10, 2); // Amount paid
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_records');
    }
};
