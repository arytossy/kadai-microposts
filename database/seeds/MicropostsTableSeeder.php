<?php

use Illuminate\Database\Seeder;

class MicropostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = App\User::all()->pluck('id')->toArray();
        
        for ($i = 1; $i <= 100; $i++) {
            DB::table('microposts')->insert([
                'content' => 'sample content ' . $i . PHP_EOL . Str::random(10),
                'user_id' => $user_ids[rand(0, count($user_ids) - 1)],
                'created_at' => date('Y-m-d H:i:s', 60 * 60 * 24 * $i),
            ]);
        }
    }
}
