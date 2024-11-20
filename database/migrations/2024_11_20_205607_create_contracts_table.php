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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('land_id')->constrained('lands')->onDelete('cascade');
            $table->string('sponsorship_contract_path'); // Path to Sponsorship Contract PDF
            $table->string('participation_contract_path'); // Path to Participation Contract PDF
            $table->string('personal_id_path'); // Path to Personal ID Card PDF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
