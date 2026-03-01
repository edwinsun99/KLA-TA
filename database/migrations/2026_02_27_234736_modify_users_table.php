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
    Schema::table('users', function (Blueprint $table) {

        // Hapus kolom name
        $table->dropColumn('name');
        $table->dropColumn('email_verified_at');

        // Tambah kolom baru
        $table->string('username')->unique()->after('id');
        $table->string('profile_photo')->nullable()->after('email');
        $table->string('role', 50)->nullable()->after('password');
        $table->foreignId('branch_id')
              ->nullable()
              ->after('role')
              ->constrained('branches')
              ->nullOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
