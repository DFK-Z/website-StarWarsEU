<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('private_messages', function (Blueprint $table) {
            $table->string('conversation_id')->after('id'); // для группировки диалогов
            $table->timestamp('read_at')->nullable()->after('is_read');
        });
    }

    public function down(): void
    {
        Schema::table('private_messages', function (Blueprint $table) {
            $table->dropColumn(['conversation_id', 'read_at']);
        });
    }
};
