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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("name");
            $table->string("description");
            $table->string("task");
            $table->string("image");
            $table->string("image_public_id");
            $table->date("start_date");
            $table->date("end_date");
            $table->foreignUuid('user_id')->constrained(table: "users", column:"id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
