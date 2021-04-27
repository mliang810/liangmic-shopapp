<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_contents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table('invoice_contents', function (Blueprint $table){ //bookmarks table: FK -- User ID
            $table->foreignId('order_id')->constrained('orders');
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
        Schema::dropIfExists('invoice_contents');
    }
}
