<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->index(['date', 'status']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->index(['date', 'status']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->index(['date', 'type']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('status');
            $table->index('name');
        });

        Schema::table('shipments', function (Blueprint $table) {
            $table->index(['status', 'ship_date']);
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropIndex(['date', 'status']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropIndex(['date', 'status']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['date', 'type']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['name']);
        });

        Schema::table('shipments', function (Blueprint $table) {
            $table->dropIndex(['status', 'ship_date']);
        });
    }
};
