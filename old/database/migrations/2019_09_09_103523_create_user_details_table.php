<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('parent_fname')->nullable();
            $table->string('parent_lname')->nullable();
            $table->string('country')->nullable();
            $table->string('parent_gender')->nullable();
            $table->string('child_fname')->nullable();
            $table->string('child_grade')->nullable();
            $table->string('child_gender')->nullable();
            $table->string('sibling_fname')->nullable();
            $table->string('sibling_grade')->nullable();
            $table->string('sibling_gender')->nullable();
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
