<?php
declare(strict_types=1);

use App\Database\Models\Group;
use Faker\Generator as Faker;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Group::class, static function (Faker $faker): array {
    return [
        'name' => $faker->unique()->word,
        'description' => $faker->unique()->paragraph
    ];
});
