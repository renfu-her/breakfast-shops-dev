<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('about_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->default(0)->after('id');
            $table->foreign('parent_id')
                ->references('id')
                ->on('about_categories')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('about_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
}; 