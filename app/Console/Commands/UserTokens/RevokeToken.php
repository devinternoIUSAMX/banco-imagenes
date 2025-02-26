<?php

namespace App\Console\Commands\UserTokens;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class RevokeToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:revoke-user-token {email} {token_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revoke one user token';

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

            $userToken = $user->tokens()->where('id', $inputs['token_id'])->first();
            if ($userToken) {
                $userToken->delete();
                $this->info('Token revoked');
            } else {
                $this->warn('Token not found');
            }
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }
}
