<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table){ //bookmarks table: FK -- User ID
            $table->foreignId('user_id')->constrained('users'); //who made this product?                 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('invoice_contents')){
            Schema::dropColumns('invoice_contents', ['order_id']);
        }
        Schema::dropIfExists('orders');
    }
}
