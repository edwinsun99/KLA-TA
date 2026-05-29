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
    Schema::table('consultations', function (Blueprint $table) {
        $table->foreignId('cs_id')->nullable()->constrained('users')->after('customer_id');
    });
}

public function down()
{
    Schema::table('consultations', function (Blueprint $table) {
        $table->dropForeign(['cs_id']);
        $table->dropColumn('cs_id');
    });
}
};
