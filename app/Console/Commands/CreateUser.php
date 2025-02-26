<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as RulesPassword;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user {name} {email} {password} {password_confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $inputs = $this->arguments();

        try {
            Validator::make($inputs, [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],
                'password' => ['required', 'string', RulesPassword::default(), 'confirmed'],
            ])->validate();

            User::create([
                'name' => $inputs['name'],
                'email' => $inputs['email'],
                'password' => Hash::make($inputs['password']),
            ]);

            $this->info('User registered.');
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }
}
