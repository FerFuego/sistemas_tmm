<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCriticality extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criticalities', function (Blueprint $table){
            $table->increments('id');
            $table->string('since_1')->nullable();
            $table->string('since_2')->nullable();
            $table->string('since_3')->nullable();
            $table->string('since_4')->nullable();
            $table->string('until_1')->nullable();
            $table->string('until_2')->nullable();
            $table->string('until_3')->nullable();
            $table->string('until_4')->nullable();
            $table->text('observation_1')->nullable();
            $table->text('observation_2')->nullable();
            $table->text('observation_3')->nullable();
            $table->text('observation_4')->nullable();
            $table->integer('idranges')->unsigned();
            $table->foreign('idranges')->references('id')->on('ranges');
            $table->softDeletes();
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
        schema::dropIfExists('criticalities');
    }
}
