<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->double('price', 8, 2);
            $table->string('product_image')->nullable();
            $table->string('tagStr')->nullable();
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table){ //bookmarks table: FK -- User ID
            // $table->foreignId('category_id')->constrained('category');
            $table->foreignId('user_id')->constrained('users'); //who made this product?                 
        });

        Schema::table('bookmarks', function (Blueprint $table){ 
            $table->foreignId('product_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('tags', ['product_id']);
        Schema::dropColumns('bookmarks', ['product_id']);
        Schema::dropColumns('cart_contents', ['product_id']);
        Schema::dropColumns('invoice_contents', ['product_id']);
        Schema::dropColumns('shop_contents', ['product_id']);

        Schema::dropIfExists('products');
    }
}
