<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

class UserVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        factory('Columbia\UserVoucher', 23)->create();

        Model::reguard();
    }
}