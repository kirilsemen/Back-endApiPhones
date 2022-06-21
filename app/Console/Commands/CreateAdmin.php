<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates admin user.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $name = $this->ask('Admin name');
        $email = $this->ask('Admin email');
        $password = $this->ask('Password');
        $owner = $this->confirm('Is admin an owner?');

        $admin_check = Admin::where('email', '=', $email)->first();

        if ($admin_check) {
            $this->error('This email is already exists.');
            return 1;
        }

        Admin::query()->create([
           'name' => $name,
           'email' => $email,
           'password' => $password,
           'owner' => $owner
        ]);

        return 0;
    }
}
