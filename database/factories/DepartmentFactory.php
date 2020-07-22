<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Department;
use Faker\Generator as Faker;

$factory->define(Department::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description'=> $faker->paragraph,
        'logo'=>$faker->image('public/logo',640,480, null, false)
    ];
});
