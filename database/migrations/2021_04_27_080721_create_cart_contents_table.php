<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_contents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table('cart_contents', function (Blueprint $table){ //bookmarks table: FK -- User ID
            $table->foreignId('cart_id')->constrained('carts');
            $table->foreignId('product_id')->constrained('products');        
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_contents');
    }
}
