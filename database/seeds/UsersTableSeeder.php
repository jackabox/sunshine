<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
           'name' => 'Jack Whiting',
           'email' => 'jack.whiting@adtrak.co.uk',
           'password' => password_hash('password', PASSWORD_BCRYPT),
        ]);
    }
}
