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
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => 'sample' . $i,
                'email' => 'sample' . $i . '@test.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
