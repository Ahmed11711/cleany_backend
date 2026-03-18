<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_company', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');

            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');

            $table->timestamps();

            $table->index(['category_id', 'region_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_company');
    }
};
