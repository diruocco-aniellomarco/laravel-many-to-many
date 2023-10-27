<?php

namespace Database\Seeders;

use App\Models\Tecnology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class TecnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $_tecnologies = ['html', 'css','sass','js','php', 'mysql'];

        foreach ($_tecnologies as $_tecnology) {
            $tecnology = new Tecnology();
            $tecnology->name = $_tecnology;
            $tecnology->save();
        }
    }
}
