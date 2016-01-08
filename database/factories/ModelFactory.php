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

$factory->define(User::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'email' => $faker->email,
    'password' => bcrypt(str_random(10)),
    'remember_token' => str_random(10),
  ];
});

foreach (User::roles() as $role) {
  $factory->defineAs(User::class, $role, function () use ($role, $factory) {
    $user = $factory->raw(User::class);
    return array_merge($user, ['role' => $role]);
  });
}

$factory->define(Treabar\Models\Company::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->company,
    'slug' => $faker->slug(),
    'icon' => $faker->image('public/img/companies', 256, 256, 'business')
  ];
});

$factory->define(Treabar\Models\Project::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->sentence(3),
    'slug' => $faker->slug(3)
  ];
});

$factory->define(Treabar\Models\Task::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->sentence(2)
  ];
});