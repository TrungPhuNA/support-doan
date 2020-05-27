<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(ArticleTableSeede::class);
//        \DB::table('admins')->insert([
//            'name'     => 'TrungPhuNA',
//            'email'    => 'phupt.admin94@gmail.com',
//            'phone'    => '0986420994',
//            'password' => Hash::make('123456789')
//        ]);
    }
}
