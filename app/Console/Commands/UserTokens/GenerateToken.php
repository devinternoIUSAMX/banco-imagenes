<?php

namespace App\Console\Commands\UserTokens;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-user-token {email} {token_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a user token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $inputs = $this->arguments();

        try {
            Validator::make($inputs, [
                'email' => ['exists:users,email']
            ])->validate();

            $user = User::where('email', $inputs['email'])->first();
            $token = $user->createToken($inputs['token_name']);

            $this->info($token->plainTextToken);
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }
}
