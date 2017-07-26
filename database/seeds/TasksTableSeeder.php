<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        
        DB::table('tasks')->insert([
            'user_id' => 1,
            'title' => 'title 1',
            'description' => 'desc 1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('tasks')->insert([
            'user_id' => 1,
            'title' => 'title 2',
            'description' => 'desc 2',
            'created_at' => $now,
            'updated_at' => $now,
            'done_at' => $now,
        ]);
    }
}
