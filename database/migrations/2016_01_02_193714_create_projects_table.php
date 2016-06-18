<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('projects', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->string('slug')->index();
      $table->integer('color');
      $table->date('from')->nullable();
      $table->date('to')->nullable();
      $table->integer('client_id')->unsigned()->nullable();
      $table->integer('company_id')->unsigned();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('projects');
  }
}
