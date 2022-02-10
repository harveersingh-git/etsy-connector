<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtsyProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etsy_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quantity');
            $table->string('title');
            $table->text('description');
            $table->string('price');
            $table->string('currency_code')->nullable();
            $table->string('availability')->nullable();
            $table->string('brand')->nullable();
            $table->string('condition')->nullable();
            $table->text('materials')->nullable();
            $table->text('url')->nullable();
            $table->text('image_url')->nullable();
            $table->string('shipping_template_id')->nullable();;
            $table->string('taxonomy_id')->nullable();;
            $table->string('shop_section_id')->nullable();;
            $table->string('image_ids')->nullable();
            $table->string('is_customizable')->nullable();
            $table->string('non_taxable')->nullable();
            $table->string('image')->nullable();;
            $table->string('state')->nullable();;
            $table->string('processing_min')->nullable();;
            $table->string('processing_max')->nullable();;
            $table->text('tags')->nullable();;
            $table->string('who_made')->nullable();
            $table->string('is_supply')->nullable();
            $table->string('when_made')->nullable();
            $table->string('style')->nullable();
            $table->unsignedBigInteger('listing_id')->nullable();





            // $table->longText('api_access_secret')->nullable();
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
        Schema::dropIfExists('etsy_products');
    }
}
