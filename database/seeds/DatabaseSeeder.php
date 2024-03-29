<?php
use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        factory('Columbia\User', 85)->create();

        factory('Columbia\Destination', 13)->create();

        factory('Columbia\Voucher', 27)->create();

        factory('Columbia\UserVoucher', 25)->create();

        Model::reguard();
    }
}
