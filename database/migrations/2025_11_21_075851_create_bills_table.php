<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "Laptop Payment"
            $table->decimal('total_amount', 10, 2); // Total bill amount
            $table->decimal('paid_amount', 10, 2)->default(0); // Amount paid so far
            $table->integer('total_installments'); // e.g., 12 months
            $table->integer('paid_installments')->default(0); // How many paid
            $table->decimal('installment_amount', 10, 2); // Amount per installment
            $table->string('frequency')->default('monthly'); // monthly, weekly, etc.
            $table->date('start_date'); // When first payment is due
            $table->date('next_due_date')->nullable(); // Next payment date
            $table->string('category')->nullable(); // Electronics, Rent, etc.
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Create bill payments table to track individual payments
        Schema::create('bill_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_payments');
        Schema::dropIfExists('bills');
    }
};