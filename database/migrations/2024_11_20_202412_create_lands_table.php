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
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('land_number'); // رقم القطعة
            $table->decimal('size', 10, 2); // المساحة
            $table->integer('number_of_pits'); // عدد الجور
            $table->integer('number_of_palms'); // عدد النخل
            $table->string('cultivation_count'); // زراعات
            $table->decimal('missing_count', 10, 2); // عدد الفاقد
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lands');
    }
};
