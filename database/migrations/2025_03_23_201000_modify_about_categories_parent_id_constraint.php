<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_categories', function (Blueprint $table) {
            // 先移除外鍵約束
            $table->dropForeign(['parent_id']);
            // 移除並重新添加欄位，但不添加外鍵約束
            $table->dropColumn('parent_id');
            $table->unsignedBigInteger('parent_id')->default(0)->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('about_categories', function (Blueprint $table) {
            // 恢復原始的外鍵約束
            $table->dropColumn('parent_id');
            $table->foreignId('parent_id')->default(0)->after('id')->constrained('about_categories')->cascadeOnDelete();
        });
    }
}; 