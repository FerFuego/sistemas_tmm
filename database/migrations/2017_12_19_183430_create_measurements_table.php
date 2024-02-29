<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function (Blueprint $table){
            $table->increments('id');
            $table->string('type');
            $table->date('date')->nullable();
            $table->string('place')->nullable();
            $table->string('instrument')->nullable();
            $table->text('regulation')->nullable();
            $table->text('resolution')->nullable();
            $table->string('archivo_1')->nullable();
            $table->string('archivo_2')->nullable();
            $table->string('archivo_3')->nullable();
            $table->integer('idbranch_office')->unsigned();
            $table->foreign('idbranch_office')->references('id')->on('branch_offices');
            $table->integer('idusers')->unsigned();
            $table->foreign('idusers')->references('id')->on('users');
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
        schema::dropIfExists('measurements');
    }
}
