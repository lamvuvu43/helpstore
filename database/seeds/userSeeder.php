<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['id_per'=>'1','username'=>'Lâm Vũ','email'=>'lamvuvu43@gmail.com','phone'=>'0374885769','password'=>bcrypt('12345678'),'address'=>''],
            ['id_per'=>'2','username'=>'Lâm Vũ 1','email'=>'lamvuvu44@gmail.com','phone'=>'0374885770','password'=>bcrypt('12345678'),'address'=>''],
            ['id_per'=>'3','username'=>'Lâm Vũ 2','email'=>'lamvuvu45@gmail.com','phone'=>'0374885771','password'=>bcrypt('12345678'),'address'=>'']
            ]);
    }
}
