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
    $dream = $faker->sentence;
    return [
      'dream' => $dream,
      'slug' => str_slug(str_limit($dream, 50).'-'.uniqid()),
      'keyword' => $faker->word,
      'description' => $faker->paragraph,
    ];
});

$factory->define(App\Models\DreamComment::class, function (Faker\Generator $faker) {
    return [
        'body' => $faker->sentence
    ];
});

$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
    $dream = $faker->sentence;
    return [
      'order_no' => uniqid(),
      'name' => $faker->name,
      'email' => $faker->unique()->safeEmail,
      'phone' => $faker->e164PhoneNumber,
      'qty' => rand(1,5),
      'lat' => $faker->latitude,
      'lng' => $faker->longitude,
      'location' => $faker->city,
      'status' => 1,
      'code' => str_random(60),
      'address' => $faker->address
    ];
});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    $dream = $faker->sentence;
    return [
      'code' => $faker->ean8,
      'name' => $faker->streetName,
      'stock' => 100,
      'price' => rand(100000, 500000),
      'description' => $faker->sentence,
    ];
});
$factory->define(App\Models\Boost::class, function (Faker\Generator $faker) {
    $dream = $faker->sentence;
    return [
      'boostable_type' => 'App\Models\Dream'
    ];
});

$factory->define(App\Models\Contact::class, function (Faker\Generator $faker) {
    $dream = $faker->sentence;
    return [
      'name' => $faker->name,
      'email' => $faker->unique()->safeEmail,
      'phone' => $faker->e164PhoneNumber,
      'subject' => $faker->sentence,
      'message' => $faker->paragraph
    ];
});
