<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EnsureSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ensure-super-admin {--email=superadmin@gmail.com} {--password=12345678} {--name="Super Admin"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ensure super admin account exists or create/update it with default credentials';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->option('email');
        $password = $this->option('password');
        $name = $this->option('name');

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'super_admin',
            'id_departemen' => null,
        ];

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update($data);
            $this->info("✓ Super admin account updated: {$email}");
        } else {
            User::create($data);
            $this->info("✓ Super admin account created: {$email}");
        }

        $this->line("Email: {$email}");
        $this->line("Password: {$password}");

        return 0;
    }
}
