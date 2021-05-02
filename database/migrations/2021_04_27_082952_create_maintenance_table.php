<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->boolean('on');
            $table->timestamps();
        });

        Schema::table('shops', function (Blueprint $table){ 
            //$table->foreign('maintenance_id')->references('id')->on('maintenances'); 
            // had to rename maintenance->maintenances for this to work???
            $table->foreignId('maintenance_id')->constrained();
        });

        DB::table('maintenances')->insert([
            'on'=>false
        ]);

        DB::table('shops')->insert([
            'shopName'=> 'Test Shop',
            'maintenance_id'=>1,
            'user_id' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('shops', ['maintenance_id']);
        Schema::dropIfExists('maintenances');
    }
}
