<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('invoices', function (Blueprint $table) {
      $table->increments('id');
      $table->string('name');
      $table->integer('invoiceno');
      $table->date('issued_at');
      $table->string('icon');
      $table->string('client');
      $table->string('company');
      $table->string('items'); //Is actually json
      $table->integer('project_id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::drop('invoices');
  }
}
