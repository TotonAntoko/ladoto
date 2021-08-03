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
        DB::table('admins')->insert([
          'username' => 'admin',
          'password'=> '$2b$10$eTK4Pfme6CsB1FdVOLPXxuqii43tFbK4d6kLDPz/j/3ZXpxjQ2IKC',
          'status' => 1
        ]);
    }
}
