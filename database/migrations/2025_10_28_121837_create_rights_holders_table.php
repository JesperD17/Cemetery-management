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
        Schema::create('rights_holders', function (Blueprint $table) {
            $table->id();
            $table->string("first_name");
            $table->string("infix");
            $table->string("last_name");
            $table->string("address");
            $table->string("city");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rights_holders');
    }
};
