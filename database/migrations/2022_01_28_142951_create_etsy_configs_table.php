<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtsyConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etsy_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('app_url')->nullable();;
            $table->string('key_string');
            $table->string('shared_secret');
            $table->string('access_token_secret')->nullable();;
            $table->string('access_token')->nullable();
            $table->string('shop_name');
            $table->string('user_name');
            $table->string('country_id')->nullable();
            $table->string('store_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etsy_configs');
    }
}
