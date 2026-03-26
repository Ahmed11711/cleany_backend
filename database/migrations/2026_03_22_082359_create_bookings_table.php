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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');

            // تفاصيل الموعد
            $table->date('booking_date'); // التاريخ اللي اختاره
            $table->time('start_time');   // وقت البداية
            $table->integer('hours')->default(1); // عدد الساعات اللي زودها العميل
            $table->time('end_time');     // وقت النهاية (بيتحسب Start + Hours)

            // تفاصيل السعر (مهم جداً نخزنها كأرقام وقت الحجز)
            $table->decimal('unit_price', 8, 2);  // سعر الساعة وقت الحجز (سواء عادي أو سعر اليوم)
            $table->integer('discount_applied')->default(0); // الخصم اللي كان موجود وقتها
            $table->decimal('total_price', 8, 2); // الإجمالي النهائي بعد الحساب

            // الحالة (Status)
            // pending: لسه مدفعش، confirmed: دفع، cancelled: اتلغى
            $table->string('status')->default('pending');
            $table->string('payment_status')->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
