<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        factory('Columbia\Voucher', 50)->create();

        Model::reguard();
    }
}
