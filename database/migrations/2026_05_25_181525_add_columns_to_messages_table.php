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
    Schema::table('messages', function (Blueprint $table) {
        $table->foreignId('consultation_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->nullable()->constrained();
        $table->enum('sender_type', ['customer', 'ai', 'cs']);
        $table->text('body');
    });
}

public function down()
{
    Schema::table('messages', function (Blueprint $table) {
        $table->dropForeign(['consultation_id']);
        $table->dropForeign(['user_id']);
        $table->dropColumn(['consultation_id', 'user_id', 'sender_type', 'body']);
    });
}
};
