<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Treabar\Models\User;
use Treabar\Models\Company;
use Treabar\Models\Project;
use Treabar\Models\Task;
use Treabar\Models\Comment;


class DatabaseSeeder extends Seeder {
  public function run() {
    $this->truncate();

  }

  private function truncate() {
    $tables = array_except(DB::select('SHOW TABLES'), ['migrations']);
    foreach($tables as $table) {
      DB::table($table)->truncate();
    }
  }
}
