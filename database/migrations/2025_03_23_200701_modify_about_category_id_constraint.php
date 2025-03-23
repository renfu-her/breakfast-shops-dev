<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            // 先移除外鍵約束
            $table->dropForeign(['category_id']);
            // 移除並重新添加欄位，但不添加外鍵約束
            $table->dropColumn('category_id');
            $table->unsignedBigInteger('category_id')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('abouts', function (Blueprint $table) {
            // 恢復原始的外鍵約束
            $table->dropColumn('category_id');
            $table->foreignId('category_id')->nullable()->after('id')->constrained('about_categories')->nullOnDelete();
        });
    }
}; 