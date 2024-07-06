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
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string("label");
            $table->string("value")->nullable()->default(null);
            $table->integer("createdBy")->nullable()->default(null);
            $table->timestamp("createdDtm")->useCurrent();
            $table->integer("updatedBy")->nullable()->default(null);
            $table->timestamp("updatedDtm")->useCurrent()->useCurrentOnUpdate();
            $table->integer("deleted")->nullable()->default(null);
            $table->integer("deletedRole")->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
