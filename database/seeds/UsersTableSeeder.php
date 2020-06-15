<?php
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@gmail.com',
            'name' => 'Chu Dai Admin',
            'role' => 'admin',
            'password' => bcrypt('Admin123456')
        ]);

        User::create([
            'email' => 'user@gmail.com',
            'name' => 'Nguyễn Văn Thiện User',
            'role' => 'user',
            'password' => bcrypt('Admin123456')
        ]);

        User::create([
            'email' => 'user2@gmail.com',
            'name' => 'Adam David',
            'role' => 'user',
            'password' => bcrypt('Admin123456')
        ]);
    }
}
