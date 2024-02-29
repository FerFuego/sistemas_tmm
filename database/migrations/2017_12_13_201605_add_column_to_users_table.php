<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nulleable()->default('NULL');
            $table->string('address')->nulleable()->default('NULL');
            $table->string('company')->nulleable()->default('NULL');
            $table->string('mediciones')->nulleable()->default('NULL');
            $table->string('location')->nulleable()->default('NULL');
            $table->string('username')->nulleable();
            $table->string('avatar')->nulleable()->default('NULL');
            $table->softDeletes ();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('company');
            $table->dropColumn('mediciones');
            $table->dropColumn('username');
            $table->dropColumn('avatar');
        });
    }
}
