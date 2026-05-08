<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('toko')->create('level_permission', function (Blueprint $table) {
            $table->string('level_kode', 50);
            $table->string('permission', 100);
            $table->primary(['level_kode', 'permission']);
        });
    }

    public function down(): void
    {
        Schema::connection('toko')->dropIfExists('level_permission');
    }
};