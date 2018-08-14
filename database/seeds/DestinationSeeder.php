<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        factory('Columbia\Destination', 50)->create();

        Model::reguard();
    }
}
