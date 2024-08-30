<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')
        ->insert([
            'name' => 'admin',
            'email' => 'adminLaundry@gmail.com',
            'password' => '$2b$10$RdhaiZwovJIrI17j3UoFR.wn5aBTeIMu0/l7Zxl/gri1RfsRWC/Xe', //admin123
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
            'telp' => '0218201145',
            'alamat' => 'Jalan Babarsari No 43',
            'url' => null
        ]);
    }
}
