<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateAPIConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:config';

    /**
     * The console command description
     *
     * @var string
     */
    protected $description = 'Adds a configuration file with client ID and client secret for inter API access';

    protected $file;

    protected $apiPHPPath;

    protected $apiJSPath;

    public function __construct(Filesystem $file) {
        $this->file = $file;
        $this->apiPHPPath = base_path() . '/config/api.php';
        $this->apiJSPath = base_path() . '/config/api.js';
        parent::__construct();
    }

    public function handle() {
        $clientsTable = \DB::table('oauth_clients')->where('id', 2)->first();

        $id = $clientsTable->id;
        $secret = $clientsTable->secret;

        $phpContent = "<?php
        return [
            'root_url'=>'http://localhost:8000/',
            'base_url'=>'http://localhost:8000/api/v1/',
            'client_id'=>{$id},
            'client_secret'=>'{$secret}'
        ];";

        $jsContent = "export default {
            root_url:'http://localhost:8000/',
            base_url:'http://localhost:8000/api/v1/',
            client_id: {$id},
            client_secret: '{$secret}'
        };";

        $this->file->put($this->apiPHPPath, $phpContent);
        $this->file->put($this->apiJSPath, $jsContent);

        $this->info('API config files created in config folder. Please move api.js to your app\'s config directory');
    }
}