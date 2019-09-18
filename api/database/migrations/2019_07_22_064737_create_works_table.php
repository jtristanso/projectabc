<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('works', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('account_id');
        $table->string('company_name');
        $table->string('position');
        $table->string('location');
        $table->longText('work_description');
        $table->integer('year_started')->nullable();
        $table->integer('year_ended')->nullable();
        $table->string('month_started')->nullable();
        $table->string('month_ended')->nullable();
        $table->timestamps();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('works');
    }
}
