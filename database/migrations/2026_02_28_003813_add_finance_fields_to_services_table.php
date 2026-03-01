<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('services', function (Blueprint $table) {
        $table->decimal('total_cost', 15, 2)->nullable();
        $table->string('invoice_number')->nullable();
        $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            //
        });
    }
};
