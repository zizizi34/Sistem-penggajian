<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'superadmin@gmail.com';

        $data = [
            'name' => 'Super Admin',
            'email' => $email,
            'password' => Hash::make('12345678'),
            'role' => 'super_admin',
            'id_departemen' => null,
        ];

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update($data);
        } else {
            User::create($data);
        }
    }
}
