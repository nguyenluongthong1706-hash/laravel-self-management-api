<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->renameColumn('level1', 'province');
            $table->renameColumn('level2', 'district');
            $table->renameColumn('level3', 'ward');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->renameColumn('province', 'level1');
            $table->renameColumn('district', 'level2');
            $table->renameColumn('ward', 'level3');
        });
    }
};
