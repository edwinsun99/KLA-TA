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
      Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->string('cof_id');
    $table->foreignId('branch_id')->nullable()->constrained('branches')->nullOnDelete();
    $table->string('contact', 100);
    $table->string('received_date')->nullable();

    $table->enum('status', [
        'new',
        'repair progress',
        'quotation request',
        'quotation approved',
        'quotation cancelled',
        'finish repair',
        'cancel repair',
        'close repair'
    ])->default('new');

    $table->string('started_date')->nullable();
    $table->date('finished_date')->nullable();

    $table->string('customer_name', 100);
    $table->string('email')->nullable();
    $table->text('address')->nullable();
    $table->string('phone_number', 20)->nullable();

    $table->string('brand');
    $table->string('product_number')->nullable();
    $table->string('serial_number')->nullable();
    $table->string('nama_type')->nullable();

    $table->text('fault_description')->nullable();
    $table->text('accessories')->nullable();
    $table->text('kondisi_unit')->nullable();
    $table->text('repair_summary')->nullable();

    $table->string('erf_file')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
