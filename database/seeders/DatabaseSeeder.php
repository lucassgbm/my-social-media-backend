<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Clodoaldo Pereira',
            'email' => 'ti.gilvan@gmail.com',
            'password' => bcrypt('12345678'),
            'photo' => 'users/avatar.jpg',
            'birthdate' => '1980-10-10',
            'autodescription' => 'Desenvolvedor Full Stack PHP/Laravel e ReactJS',
        ]);

        $this->call([
            CategorySeeder::class
        ]);
    }
}
