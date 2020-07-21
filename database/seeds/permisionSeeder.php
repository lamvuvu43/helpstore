<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class permisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permision')->insert([['detail'=>'Quản trị viên'],['detail'=>'Chủ cửa hàng'],['detail'=>'Nhân viên']]);
    }
}
