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
            $table->date('booking_date');
            $table->time('start_time');
            $table->integer('hours')->default(1);
            $table->time('end_time');
            $table->decimal('unit_price', 8, 2);
            $table->integer('discount_applied')->default(0);
            $table->decimal('total_price', 8, 2);

            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])
                ->default('pending');

            $table->enum('payment_status', ['unpaid', 'paid', 'cash_on_hand'])
                ->default('unpaid');


            $table->enum('payment_method', ['wallet', 'cash_on_hand', 'payment'])->nullable();
            $table->string('address')->nullable();
            $table->text('notes')->nullable();
            $table->integer('staff_id')->nullable();
            $table->string('transaction_id')->nullable();
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
