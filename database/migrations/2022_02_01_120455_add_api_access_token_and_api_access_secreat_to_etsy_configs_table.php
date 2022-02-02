<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiAccessTokenAndApiAccessSecreatToEtsyConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etsy_configs', function (Blueprint $table) {
            $table->longText('api_access_token')->after('store_id')->nullable();
            $table->longText('api_access_secret')->after('api_access_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etsy_configs', function (Blueprint $table) {
            $table->dropIfExists('api_access_token');
            $table->dropIfExists('api_access_secret');
        });
    }
}
