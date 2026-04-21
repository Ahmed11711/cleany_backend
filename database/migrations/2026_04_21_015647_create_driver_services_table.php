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
        Schema::create('driver_services', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_item_id')->constrained('service_items')->onDelete('cascade');

            $table->string('title')->nullable();
            $table->string('title_ar')->nullable();

            $table->text('desc')->nullable();
            $table->text('desc_ar')->nullable();

            $table->decimal('price', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_services');
    }
};
