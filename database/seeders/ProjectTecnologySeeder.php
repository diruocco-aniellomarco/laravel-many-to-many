<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Project;
use App\Models\Tecnology;

class ProjectTecnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $projects = Project::all();                                // object Post
        $tecnologies = Tecnology::all()->pluck('id')->toArray(); // array  [1, 2, ... n]

        foreach($projects as $project) {
            $project
            ->tecnologies()
            ->attach($faker->randomElements($tecnologies, random_int(1, 3)));
        }
    }
}
