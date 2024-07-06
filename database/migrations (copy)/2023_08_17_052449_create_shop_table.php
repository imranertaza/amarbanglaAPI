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
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('sch_id');
            $table->string("name", 155);
            $table->string("email", 30)->nullable()->default(null);
            $table->double("cash")->unsigned();
            $table->integer("del_balance")->nullable()->default(null);
            $table->integer("reserve_cash")->nullable()->default(null);
            $table->integer("sup_comm");
            $table->text("address")->nullable()->default(null);
            $table->integer("global_address_id")->nullable()->default(null);
            $table->integer("mobile")->nullable()->default(null);
            $table->text("comment")->nullable()->default(null);
            $table->string("logo", 155)->nullable()->default(null);
            $table->string("image", 155)->nullable()->default(null);
            $table->string("banner", 155)->nullable()->default(null);
            $table->enum("is_default", [1, 0])->default(0);
            $table->integer("shop_cat_id")->nullable()->default(null);
            $table->enum("priority", [1, 0])->default(0);
            $table->integer("sms")->nullable()->default(null);
            $table->enum("home_feature", [1, 0])->default(0);
            $table->enum("type", ['Man', 'Women', 'Both'])->default('Both');
            $table->enum("status", [1, 0])->default(1);
            $table->enum("opening_status", [1, 0])->default(1);
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
        Schema::dropIfExists('shops');
    }
};
