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
        Schema::create('grave_agreements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("rights_holder_id");
            $table->unsignedBigInteger("grave_id");
            $table->string("start_date");
            $table->string("end_date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grave_agreements');
    }
};
