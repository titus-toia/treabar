<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('activities', function (Blueprint $table) {
      $table->increments('id');
      $table->string('description');
      $table->dateTime('started_at');
      $table->integer('duration')->unsigned();
      $table->integer('task_id')->nullable()->unsigned();
      $table->integer('invoice_id')->nullable()->unsigned();
      $table->integer('project_id')->unsigned();
      $table->integer('user_id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('activities');
  }
}
