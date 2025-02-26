<?php

namespace App\Console\Commands\UserTokens;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class ShowTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:show-user-tokens {email}';

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

            $user = User::withEmail($inputs['email'])->first();

            $userTokens = $user->tokens()->select(['id', 'name', 'created_at', 'last_used_at'])->get();
            if ($userTokens->count() > 0)
                $this->table(['ID', 'Name', 'Created At', 'Last Use'], $userTokens);
            else
                $this->warn('User does not have tokens');
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }
}
