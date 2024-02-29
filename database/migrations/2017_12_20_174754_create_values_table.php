<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('values', function (Blueprint $table){
            $table->increments('id');;
            $table->date('date')->nullable();
            $table->string('title')->nullable();
            $table->string('value_num')->nullable();
            $table->text('value')->nullable();
            $table->string('value_max')->nullable();
            $table->string('type')->nullable();
            $table->string('state')->nullable();
            $table->text('details')->nullable();
            $table->string('reparation')->nullable();
            $table->string('criterion')->nullable();
            $table->text('observation')->nullable();
            $table->text('recommendation')->nullable();
            $table->text('other')->nullable();
            $table->string('image_1')->nullable();
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable();
            $table->softDeletes ();
            $table->integer('idmeasurements')->unsigned();
            $table->foreign('idmeasurements')->references('id')->on('measurements');
            $table->integer('idbranch_office')->unsigned();
            $table->foreign('idbranch_office')->references('id')->on('branch_offices');
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
        schema::dropIfExists('values');
    }
}
