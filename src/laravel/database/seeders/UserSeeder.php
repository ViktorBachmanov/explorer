<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

use App\Models\User;


class UserSeeder extends Seeder
{
    const PASSWORD = '123';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'id' => 1,
            'name' => 'admin-1',
            'email' => 'admin-1@mail.ru',
            'password' => Hash::make(self::PASSWORD),
            'is_admin' => true,
        ]);

        User::firstOrCreate([
            'id' => 2,
            'name' => 'admin-2',
            'email' => 'admin-2@mail.ru',
            'password' => Hash::make(self::PASSWORD),
            'is_admin' => true,
        ]);

        User::firstOrCreate([
            'id' => 3,
            'name' => 'user-1',
            'email' => 'user-1@mail.ru',
            'password' => Hash::make(self::PASSWORD),
            'is_admin' => false,
        ]);

        User::firstOrCreate([
            'id' => 4,
            'name' => 'user-2',
            'email' => 'user-2@mail.ru',
            'password' => Hash::make(self::PASSWORD),
            'is_admin' => false,
        ]);

        User::firstOrCreate([
            'id' => 5,
            'name' => 'user-3',
            'email' => 'user-3@mail.ru',
            'password' => Hash::make(self::PASSWORD),
            'is_admin' => false,
        ]);
    }
}
