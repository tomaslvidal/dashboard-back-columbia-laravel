<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        factory('Columbia\User', 350)->create();

        Model::reguard();
    }
}
