<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRangesValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ranges_values', function (Blueprint $table){
            $table->increments('id');
            $table->string('since')->nullable();
            $table->string('until')->nullable();
            $table->string('icono')->nullable();
            $table->text('observation')->nullable();
            $table->text('recomendation')->nullable();
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
        schema::dropIfExists('ranges_values');
    }
}
