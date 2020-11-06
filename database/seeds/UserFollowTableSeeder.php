<?php

use Illuminate\Database\Seeder;

class UserFollowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (App\User::all() as $user) {
            foreach (App\User::all() as $target) {
                if (rand(0, 1)) $user->follow($target->id);
            }
        }
    }
}
