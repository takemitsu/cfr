<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {

    $project = \App\Models\Project::orderBy('id', 'desc')->first();
    $is_product = random_int(0, 1);
    return [
        'service_id' => $project->service_id,
        'project_id' => $project->id,
        'nickname' => $faker->name,
        'score_product' => $faker->randomElement([1, 2, 3, 4, 5]),
        'score_vendor' => $faker->randomElement([1, 2, 3, 4, 5]),
        'score_retry' => $faker->randomElement([1, 2, 3, 4, 5]),
        'score_total' => $faker->randomElement([1, 2, 3, 4, 5]),
        'comment' => $faker->text,
        'product_name' => $is_product ? $faker->word : null,
    ];
});
