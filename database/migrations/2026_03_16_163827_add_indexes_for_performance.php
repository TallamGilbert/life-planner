<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Expenses indexes
        Schema::table('expenses', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('date');
            $table->index('type');
            $table->index(['user_id', 'date']);
            $table->index(['user_id', 'type']);
        });

        // Habits indexes
        Schema::table('habits', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('is_active');
            $table->index('last_completed');
            $table->index(['user_id', 'is_active']);
        });

        // Meals indexes
        Schema::table('meals', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('date');
            $table->index(['user_id', 'date']);
        });

        // Bills indexes
        Schema::table('bills', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('is_active');
            $table->index(['user_id', 'is_active']);
        });

        // Bill payments indexes
        Schema::table('bill_payments', function (Blueprint $table) {
            $table->index('bill_id');
            $table->index('user_id');
            $table->index('payment_date');
            $table->index(['bill_id', 'payment_date']);
        });
    }

    public function down(): void
    {
        // Drop all indexes
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['date']);
            $table->dropIndex(['type']);
            $table->dropIndex(['user_id', 'date']);
            $table->dropIndex(['user_id', 'type']);
        });

        Schema::table('habits', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['last_completed']);
            $table->dropIndex(['user_id', 'is_active']);
        });

        Schema::table('meals', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['date']);
            $table->dropIndex(['user_id', 'date']);
        });

        Schema::table('bills', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['user_id', 'is_active']);
        });

        Schema::table('bill_payments', function (Blueprint $table) {
            $table->dropIndex(['bill_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['payment_date']);
            $table->dropIndex(['bill_id', 'payment_date']);
        });
    }
};
