<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('shopName');
            $table->binary('banner_image')->nullable();
            $table->timestamps();
        });

        Schema::table('shops', function (Blueprint $table){ //bookmarks table: FK -- User ID
            $table->foreignId('user_id')->constrained('users');            
            // $table->foreignId('maint_id')->constrained('maintenance');       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        if (Schema::hasTable('shop_contents')){
            Schema::dropColumns('shop_contents', ['shop_id']);
        }
        Schema::dropIfExists('shops');
    }
}
