
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\Dropbox;
use GuzzleHttp\Client;
use App\Models\User;

class TokenDropboxUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update token in dropbox';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        info("Token Update ". now());
        //aqui ira el proceso de update token
        //session_start();
        $dropboxKey ="poryms6kbeheedh";
        $dropboxSecret ="y2qkczqhvafuhdh";
    try {
        $client = new \GuzzleHttp\Client();
        $res = $client->request("POST", "https://{$dropboxKey}:{$dropboxSecret}@api.dropbox.com/oauth2/token", [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => 'nnvS5xYRi9cAAAAAAAAAASsVh-hjF-hb0oV2uYjJDe2i9dIu2lSb-rncy7_-P1yL',
                ]
        ]);
        if ($res->getStatusCode() == 200) {
            $data = json_decode($res->getBody(), TRUE);
            //$_SESSION['dropbox_token']= $data['access_token'];
            $user = User::find(1);
            $user->dropbox_token = $data['access_token'];
            $user->save();
            return 0;
        } else {
            return 0;
        }
    }
    catch (Exception $e) {
        $this->logger->error("[{$e->getCode()}] {$e->getMessage()}");
        return 0;
    }
        return 0;
    }
}
