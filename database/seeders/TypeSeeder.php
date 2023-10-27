<?php

namespace Database\Seeders;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types_seed = ["Front-end","Back-end","Full Stack"];
        foreach($types_seed as $type_seed) {
            $type = new Type();
            $type->label = $type_seed;
            
            $type->save();
          }
    }
}
