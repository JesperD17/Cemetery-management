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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign("role_id")->references("id")->on("roles")->onDelete("cascade");
            $table->foreign("id")->references("user_id")->on("grave_users")->onDelete("cascade");
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->foreign("permission_id")->references("id")->on("permissions")->onDelete("set null");
        });

        Schema::table('grave_users', function (Blueprint $table) {
            $table->foreign("grave_id")->references("id")->on("graves")->onDelete("cascade");
        });

        Schema::table('graves', function (Blueprint $table) {
            $table->foreign("status_id")->references("id")->on("grave_statuses")->onDelete("set null");
            $table->foreign("id")->references("grave_id")->on("grave_of_deceased")->onDelete("set null");
        });

        Schema::table('grave_of_deceased', function (Blueprint $table) {
            $table->foreign("deceased_id")->references("id")->on("deceased")->onDelete("cascade");
        });

        Schema::table('cemeteries', function (Blueprint $table) {
            $table->foreign("id")->references("cemetery_id")->on("graves")->onDelete("set null");
            $table->foreign("municipality_id")->references("id")->on("municipalities")->onDelete("set null");
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
