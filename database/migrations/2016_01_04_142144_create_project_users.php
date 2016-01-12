<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectUsers extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('project_users', function (Blueprint $table) {
      $table->integer('project_id')->unsigned();
      $table->integer('user_id')->unsigned();
      $table->primary(['project_id', 'user_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('project_users');
  }
}
