<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop_keeper:create {name} {email} {pass}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new shop keeper user.';

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
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $pass = $this->argument('pass');

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($pass),
            'role' => 'shop_keeper',
            'status' => 1,
        ]);
    }
}
