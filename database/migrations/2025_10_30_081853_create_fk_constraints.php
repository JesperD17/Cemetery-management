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
        Schema::table('graves', function (Blueprint $table) {
            $table->foreign("cemetery_id")->references("id")->on("cemeteries")->onDelete("cascade");
        });

        Schema::table('grave_agreements', function (Blueprint $table) {
            $table->foreign("rights_holder_id")->references("id")->on("rights_holders")->onDelete("cascade");
            $table->foreign("grave_id")->references("id")->on("graves")->onDelete("cascade");
        });

        Schema::table('grave_of_deceased', function (Blueprint $table) {
            $table->foreign("deceased_id")->references("id")->on("deceased")->onDelete("cascade");
            $table->foreign("grave_id")->references("id")->on("graves")->onDelete("cascade");
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fk_constraints');
    }
};
