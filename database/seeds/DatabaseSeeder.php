<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

use Treabar\Models\User;
use Treabar\Models\Company;
use Treabar\Models\Project;
use Treabar\Models\Task;
use Treabar\Models\Comment;


class DatabaseSeeder extends Seeder {


  public function run() {
    $this->truncate();
    $faker = Faker::create();

    factory(User::class, User::ROLE_ROOT)->create();

    factory(Company::class, rand(2, 3))->create();

    foreach(Company::all() as $company) {
      $company_id = $company->id;
      factory(User::class, User::ROLE_MANAGER)->create(['company_id' => $company_id]);
      $devs = factory(User::class, User::ROLE_DEV, rand(5, 7))->create(['company_id' => $company_id]);
      $clients = factory(User::class, User::ROLE_CLIENT, rand(1, 3))->create(['company_id' => $company_id]);

      foreach(range(1, rand(3, 6)) as $i) {
        factory(Project::class)->create([
          'company_id' => $company_id,
          'client_id' => $faker->optional()->randomElement($clients->lists('id')->all())
        ]);
      }

      $projects = $company->projects();
      foreach(range(1, rand(10, 15)) as $i) {
        factory(Task::class)->create([
          'project_id' => $faker->randomElement($projects->lists('id')->all())
        ]);
      }

      $project_ids = $projects->lists('id')->all();
      foreach($devs as $dev) {
        $ids = array_values(array_only($project_ids, array_rand($project_ids)));
        $dev->projects()->sync($ids);
      }
    }
  }

  private function truncate() {
    $tables = array_except(DB::select('SHOW TABLES'), ['migrations']);
    foreach($tables as $table) {
      DB::table(array_values((array)$table)[0])->truncate();
    }

    foreach(glob(public_path('img/users/*')) as $file) {
      if(is_file($file)) unlink($file);
    }

    foreach(glob(public_path('img/companies/*')) as $file) {
      if(is_file($file)) unlink($file);
    }
  }
}
