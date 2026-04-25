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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('subject', 150);
            $table->string('product_group', 10); // PG / DSG
            $table->string('category', 50);      // hardware / software / network / consumable / other
            // $table->string('device_type', 50);   // printer / laptop / pc / other
            $table->string('brand_model', 70)->nullable();
            // $table->string('serial_number', 100)->nullable();
            $table->text('description');

            $table->string('status', 30)->default('active');
            // contoh status: active, waiting_response, closed, escalated

            $table->timestamps();

            $table->index(['customer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};