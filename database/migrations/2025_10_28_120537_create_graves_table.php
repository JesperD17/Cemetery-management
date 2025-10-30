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
        Schema::create('graves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cemetery_id");
            $table->string("latitude");
            $table->string("longitude");
            $table->string("image_url");
            $table->string("number");
            $table->string("costs");
            $table->string("type");
            $table->string("term");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graves');
    }
};
