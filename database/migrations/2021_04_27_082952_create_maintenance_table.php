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
            $table->string('name');
            $table->timestamps();
        });

        DB::table('maintenances')->insert([ 
            'name'=>'online'
        ]);

        DB::table('maintenances')->insert([ // maint table only has two entries. online-->1, and offline --> 2
            'name'=>'offline'
        ]);

        Schema::table('shops', function (Blueprint $table){ 
            //$table->foreign('maintenance_id')->references('id')->on('maintenances'); 
            // had to rename maintenance->maintenances for this to work???
            $table->foreignId('maintenance_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('shops', ['maint_id']);
        Schema::dropIfExists('maintenances');
    }
}
