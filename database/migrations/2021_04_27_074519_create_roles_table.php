<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->string('slug');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table){
            // $table->foreign('role_id')->references('id')->on('roles');
            $table->foreignId('role_id')->constrained();
        });

        $roles = [
            'shopper'=>'Shopper',
            'shopOwner'=>'ShopOwner' //ShopOwners have the samne permissions as shoppers, but not vice versa
        ];

        foreach($roles as $slug=>$name){
            // MASS ASSIGNMENT -- laravel auto blocks it, so to get around it, you have to specify which properties youll allow to be mass assigned (done in the Model)
            Role::create([
                'slug'=>$slug,
                'name'=>$name,
            ]);
        }

        // $results = DB::table('users')->get('id');
        // foreach ($results as $result){
        //     DB::table('users')->where('id', '=', $result->id)->update(['role_id'=>1]); 
        //     //everyone is automatically a shopper, if there are users in the users table for some reason
        // }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('users', ['role_id']);
        Schema::dropIfExists('roles');
    }
}
