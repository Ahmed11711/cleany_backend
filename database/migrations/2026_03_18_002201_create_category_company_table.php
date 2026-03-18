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

            // ربط الشركة
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');

            // ربط القسم
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');

            // ربط المنطقة (يمكن أن يكون نال Nullable)
            $table->foreignId('region_id')->nullable()->constrained('regions')->onDelete('set null');

            $table->timestamps();

            // نصيحة: إضافة Index لتحسين سرعة البحث بالمنطقة والقسم
            $table->index(['category_id', 'region_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_company');
    }
};
