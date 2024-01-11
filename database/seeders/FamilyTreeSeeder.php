<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilyTreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('family_trees')->insert([
            ['name' => 'budi', 'birth_date' => '1960-01-01', 'gender' => 'male', 'parent_id' => null],
            ['name' => 'dedi', 'birth_date' => '1988-01-01', 'gender' => 'male', 'parent_id' => 1],
            ['name' => 'dodi', 'birth_date' => '1989-01-01', 'gender' => 'male', 'parent_id' => 1],
            ['name' => 'dede', 'birth_date' => '1990-01-01', 'gender' => 'male', 'parent_id' => 1],
            ['name' => 'dewi', 'birth_date' => '1991-01-01', 'gender' => 'female', 'parent_id' => 1],
            ['name' => 'feri', 'birth_date' => '2014-01-01', 'gender' => 'male', 'parent_id' => 2],
            ['name' => 'farah', 'birth_date' => '2018-01-01', 'gender' => 'female', 'parent_id' => 2],
            ['name' => 'gugus', 'birth_date' => '2016-01-01', 'gender' => 'male', 'parent_id' => 3],
            ['name' => 'gandi', 'birth_date' => '2017-01-01', 'gender' => 'male', 'parent_id' => 3],
            ['name' => 'hani', 'birth_date' => '2015-01-01', 'gender' => 'female', 'parent_id' => 4],
            ['name' => 'hana', 'birth_date' => '2019-01-01', 'gender' => 'female', 'parent_id' => 4],
        ]);
    }
}
