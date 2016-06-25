<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
use Treabar\Models\User;
use Treabar\Models\Activity;
use Treabar\Models\Project;

$random_img = function($origin, $target) {
  $imgs = array_diff(scandir(public_path($origin)), ['..', '.']);
  $img = $imgs[array_rand($imgs)];
  $name = uniqid()  . $img;
  copy(public_path($origin . '/') . $img, public_path($target) . $name);
  return $name;
};

$factory->define(User::class, function (Faker\Generator $faker) use($random_img) {
  return [
    'name' => $faker->name,
    'email' => $faker->email,
    'password' => bcrypt(str_random(10)),
    'remember_token' => str_random(10),
    'icon' => call_user_func($random_img, 'img/dev/users', 'img/users/')
  ];
});

foreach (User::roles() as $role) {
  $factory->defineAs(User::class, $role, function () use ($role, $factory) {
    $user = $factory->raw(User::class);
    return array_merge($user, ['role' => $role]);
  });
}

$factory->define(Treabar\Models\Company::class, function (Faker\Generator $faker) use($random_img) {
  return [
    'name' => $faker->company,
    'slug' => $faker->slug(),
    'icon' => call_user_func($random_img, 'img/dev/companies', 'img/companies/')
  ];
});

$factory->define(Project::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->sentence(3),
    'slug' => $faker->slug(3),
    'color' => rand(1, Project::COLOR_COUNT),
    'from' => $faker->dateTimeBetween('last month', 'today'),
    'to' => $faker->dateTimeBetween('+1 months', '+2 months')
  ];
});

$factory->define(Treabar\Models\Task::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->sentence(2),
    'description' => $faker->paragraph(),
    'duration' => $faker->numberBetween(50, 150)
  ];
});

$factory->define(Treabar\Models\Activity::class, function (Faker\Generator $faker) {
  return [
    'description' => $faker->text(),
    'type' => $faker->randomElement(
      array_merge(array_fill(0, 5, Activity::TYPE_ACTIVITY), [Activity::TYPE_COMPLETION])),
    'started_at' => \Carbon\Carbon::now()->setTime('10', '30'),
    'created_at' => $faker->dateTimeBetween('-2 days', 'now'),
    'duration' => rand(1, 18) * 300 //multiples of 5 minutes
  ];
});

$factory->define(Treabar\Models\Comment::class, function (Faker\Generator $faker) {
  return [
    'content' => $faker->text(),
    'created_at' => $faker->dateTimeBetween('-2 days', 'now')
  ];
});

$factory->define(Treabar\Models\Invoice::class, function(Faker\Generator $faker) use($random_img) {
  return [
    'name' => $faker->sentence(2),
    'issued_at' => $faker->dateTimeThisMonth,
    'icon' => call_user_func($random_img, 'img/dev/companies', 'img/invoices/'),
    'client' => $faker->name,
    'company' => $faker->company,
    'items' => [[
      'name' => $faker->words(2, true),
      'hours' => $faker->numberBetween(50, 150),
      'rate' => $faker->numberBetween(10, 50),
      'total' => $faker->numberBetween(500, 2500)
    ]]
  ];
});