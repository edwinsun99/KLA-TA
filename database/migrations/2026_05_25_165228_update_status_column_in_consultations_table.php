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
    DB::statement("ALTER TABLE consultations 
    MODIFY COLUMN status ENUM('active', 'open', 'redirect_to_cs', 
    'cs_handling', 'escalated_to_kla', 'closed') NOT NULL DEFAULT 'active'");
}

public function down()
{
    DB::statement("ALTER TABLE consultations 
    MODIFY COLUMN status VARCHAR(30) NOT NULL DEFAULT 'active'");
}
};
