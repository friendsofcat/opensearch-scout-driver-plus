<?php declare(strict_types=1);

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use OpenSearch\ScoutDriverPlus\Tests\App\Store;

/** @var Factory $factory */
$factory->define(Store::class, static fn (Faker $faker) => [
    'name' => $faker->name,
    'lat' => $faker->randomNumber(),
    'lon' => $faker->randomNumber(),
]);
