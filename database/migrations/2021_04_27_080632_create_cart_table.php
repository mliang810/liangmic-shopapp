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

        Schema::table('carts', function (Blueprint $table){ 
            $table->foreignId('user_id')->constrained('users');    
        });

        // Schema::table('users', function (Blueprint $table){
        //     // $table->foreignId('cart_id')->constrained('carts');
        //     $table->foreign('cart_id')->references('id')->on('carts');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        if (Schema::hasTable('cart_contents')){ //dont actually need this -- use migrate:fresh!!! not refresh. stop forgetting <3
            Schema::dropColumns('cart_contents', ['cart_id']);
        }
        
        // Schema::dropColumns('users', ['cart_id']);
        Schema::dropIfExists('carts');
    }
}
