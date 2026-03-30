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
        Schema::create('favourites', function (Blueprint $table) {
            $table->id();

            // 1. Foreign Key naming and indexing
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 2. Fixed typo from 'caompany_id' to 'company_id'
            $table->foreignId('company_id')->constrained()->onDelete('cascade');

            $table->timestamps();

            // 3. Optional: Prevent duplicate favourites
            $table->unique(['user_id', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favourites');
    }
};
