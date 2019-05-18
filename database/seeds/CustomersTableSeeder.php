<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('customer')->insert([
            'nama' => 'Toton',
            'Alamat' => 'Malang',
            'kota' => 'Malang',
            'negara' => 'IND',
            'no_telp' => '00000',
            'status' => 1,
        ]);
    }
}
