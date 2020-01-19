<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Status::create([
            'name' => 'unchecked',
        ]);
        \App\Status::create([
            'name' => 'accepted',
        ]);
        \App\Status::create([
            'name' => 'refused',
        ]);
        \App\Status::create([
            'name' => 'downloading',
        ]);
        \App\Status::create([
            'name' => 'burned',
        ]);
        \App\Status::create([
            'name' => 'unattainable',
        ]);

    }
}
