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
        Schema::create('grave_of_deceased', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("deceased_id");
            $table->foreign("deceased_id")->references("id")->on("deceased")->onDelete("cascade");
            $table->unsignedBigInteger("grave_id");
            $table->foreign("grave_id")->references("id")->on("graves")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grave_of_deceased');
    }
};
