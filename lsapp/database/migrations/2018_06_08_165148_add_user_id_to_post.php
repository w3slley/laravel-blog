<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function($table){
            $table->integer('user_id'); //This will add this column to the database! if you run migrate into tinker, it will add to it. Now the posts table has a user_id column!
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function($table){
            $table->dropColumn('user_id'); //If you want to reverse the changes, you can run php artisan migrate:rollback to delete it.
        }); 
    }
}
