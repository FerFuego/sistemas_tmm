<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAlarms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarms', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->string('title')->nullable();
            $table->text('detail')->nullable();
            $table->text('state')->nullable();
            $table->text('name')->nullable();
            $table->text('email')->nullable();
            $table->integer('idvalues')->unsigned();
            $table->foreign('idvalues')->references('id')->on('values');
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
        Schema::dropIfExists('alarms'); 
    }
}
