<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('companies', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->integer('invoiceno')->default('0');
      $table->string('slug')->index();
      $table->string('icon');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('companies');
  }
}
