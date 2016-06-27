<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

use Treabar\Models\User;
use Treabar\Models\Company;
use Treabar\Models\Project;
use Treabar\Models\Task;
use Treabar\Models\Activity;
use Treabar\Models\Comment;
use Treabar\Models\Invoice;


class DatabaseSeeder extends Seeder {


  public function run() {
    $this->truncate();
    $faker = Faker::create();

    factory(User::class, User::ROLE_ROOT)->create();

    echo "Creating Companies..." . PHP_EOL;
    $no_companies = rand(2, 3);
    factory(Company::class, $no_companies)->create();
    echo "Created $no_companies companies." . PHP_EOL;

    foreach(Company::all() as $company) {
      $company_id = $company->id;
      echo "Processing company $company_id..." . PHP_EOL;

      echo "Creating users ..." . PHP_EOL;
      factory(User::class, User::ROLE_MANAGER)->create(['company_id' => $company_id]); //Create the general admin
      $devs = factory(User::class, User::ROLE_DEV, rand(5, 7))->create(['company_id' => $company_id]);
      $clients = factory(User::class, User::ROLE_CLIENT, rand(1, 3))->create(['company_id' => $company_id]);

      echo "Creating projects ..." . PHP_EOL;
      foreach(range(1, rand(5, 9)) as $i) {
        factory(Project::class)->create([
          'company_id' => $company_id,
          'client_id' => $faker->randomElement($clients->lists('id')->all())
        ]);
      }

      $projects = $company->projects();
      echo "Creating tasks ..." . PHP_EOL;
      foreach(range(1, rand(15, 20)) as $i) {
        $root = factory(Task::class)->create([
          'project_id' => $faker->randomElement($projects->lists('id')->all())
        ]);

        for($j = 1; $j <= rand(0, 3); $j++) {
          $task = factory(Task::class)->create(['project_id' => $root->project_id]);
          $task->makeChildOf($root);

          //Coin flip for subtask
          if($faker->boolean()) {
            $subTask = factory(Task::class)->create(['project_id' => $root->project_id]);
            $subTask->makeChildOf($task);
          }
        }
      }

      echo "Creating activities and comments ..." . PHP_EOL;
      $tasks = Task::whereIn('project_id', $projects->lists('id')->all())->get();
      foreach($tasks as $task) {
        foreach(range(1, rand(2, 10)) as $i) {
          factory(Activity::class)->create([
            'project_id' => $task->project_id,
            'task_id' => $task->id,
            'user_id' => $faker->randomElement($devs->lists('id')->all())
          ]);
        }

        foreach(range(1, rand(2, 10)) as $i) {
          factory(Comment::class)->create([
            'project_id' => $task->project_id,
            'task_id' => $task->id,
            'user_id' => $faker->randomElement($devs->lists('id')->all())
          ]);
        }
      }

      foreach($devs as $dev) {
        $dev->projects()->sync($faker->randomElements($projects->lists('id')->all(), rand(3, 4)));
      }

      echo "Creating invoices ..." . PHP_EOL;
      foreach(range(1, rand(40, 60)) as $i) {
        factory(Invoice::class)->create([
          'company_id' => $company_id,
          'project_id' => $faker->randomElement($projects->lists('id')->all()),
          'invoiceno' => $i
        ]);
      }

      $company->update([
        'invoiceno' => ++$i
      ]);

      echo "Company done." . PHP_EOL;
    }

    echo PHP_EOL. "Everything done, thanks for waiting!" . PHP_EOL;
  }

  private function truncate() {
    $tables = DB::select('SHOW TABLES');
    foreach($tables as $table) {
      $name = array_values((array)$table)[0];
      if($name !== 'migrations') DB::table($name)->truncate();
    }

    foreach(glob(public_path('img/users/*')) as $file) {
      if(is_file($file)) unlink($file);
    }

    foreach(glob(public_path('img/companies/*')) as $file) {
      if(is_file($file)) unlink($file);
    }

    foreach(glob(public_path('img/invoices/*')) as $file) {
      if(is_file($file)) unlink($file);
    }
  }
}
