<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'admin',
             'email' => 'admin@example.com',
             'password' => bcrypt('123'),
             'is_admin' => true,
         ]);

        \App\Models\User::factory()->create([
            'name' => 'client',
            'email' => 'client@example.com',
            'password' => bcrypt('123'),
        ]);
        DB::table('categories')->insert([
            'id' => 1,
            'name' => 'Uncategorized',
            'slug' => 'uncategorized'
        ]);
    }
}
