<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagetempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cat_id')->unsigned();
            $table->integer('subcat_id')->unsigned();
            $table->string('mail_subject')->nullable();
            $table->text('mail_desc')->nullable();
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
        Schema::dropIfExists('managetemps');
    }
}
