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
        // users.role_id -> roles.id
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        // grave_users.user_id -> users.id
        // grave_users.grave_id -> graves.id
        Schema::table('grave_users', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('grave_id')->references('id')->on('graves')->onDelete('cascade');
        });

        // grave_of_deceased.deceased_id -> deceased.id
        // grave_of_deceased.grave_id -> graves.id
        Schema::table('grave_of_deceased', function (Blueprint $table) {
            $table->foreign('deceased_id')->references('id')->on('deceased')->onDelete('cascade');
            $table->foreign('grave_id')->references('id')->on('graves')->onDelete('cascade');
        });

        // graves.cemetery_id -> cemeteries.id
        // graves.status_id -> grave_statuses.id
        Schema::table('graves', function (Blueprint $table) {
            $table->foreign('cemetery_id')->references('id')->on('cemeteries')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('grave_statuses')->onDelete('cascade');
        });

        // cemeteries.municipality_id -> municipalities.id
        Schema::table('cemeteries', function (Blueprint $table) {
            $table->foreign('municipality_id')->references('id')->on('municipalities')->onDelete('cascade');
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
