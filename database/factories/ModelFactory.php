<?php
use Carbon\Carbon;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    $first_name = $faker->firstNameMale;
    $username = $first_name.'-'.time();
    return [
        'first_name' => $first_name,
        'last_name' => $faker->lastName,
        'dob' => $faker->dateTimeBetween('-50 years', '-17 years'),
        'gender' => 'Male',
        'username' => $username,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'remember_token' => str_random(60)
    ];
});
$factory->define(App\Models\Profile::class, function (Faker\Generator $faker) {
    return [
        'phone' => $faker->e164PhoneNumber,
        'address' => $faker->address,
        'about' => $faker->paragraph,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
        'location' => $faker->city,
    ];
});

$factory->define(App\Models\Activation::class, function (Faker\Generator $faker) {
    return [
        'code' => str_random(40),
        'completed' => 1,
        'completed_at' => Carbon::now()
    ];
});

$factory->define(App\Models\Dream::class, function (Faker\Generator $faker) {
    return [
      'dream' => $faker->sentence,
      'keyword' => $faker->word,
      'description' => $faker->paragraph,
    ];
});
