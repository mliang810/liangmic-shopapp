<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table('carts', function (Blueprint $table){ //bookmarks table: FK -- User ID
            $table->foreignId('user_id')->constrained('users');    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::dropColumns('cart_contents', ['cart_id']);
        Schema::dropIfExists('carts');
    }
}
