<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendor_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('supplier_type')->nullable(); // seeds, fertilizers, equipment, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_groups');
    }
};
