<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seo', function (Blueprint $table) {
            $table->text('script')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('seo', function (Blueprint $table) {
            $table->text('script')->change();
        });
    }
}; 