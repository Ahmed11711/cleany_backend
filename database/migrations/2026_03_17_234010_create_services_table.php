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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('service_name');
            $table->string('service_name_ar')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('price_today', 8, 2)->nullable();
            // discount
            $table->integer('discount')->default(0); // 10%
            $table->text('standard_bags')->nullable();
            $table->text('standard_bags_ar')->nullable();
            $table->integer('max_staff')->nullable();
            $table->string('price_staff')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
