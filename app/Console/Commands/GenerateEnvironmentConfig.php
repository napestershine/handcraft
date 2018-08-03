<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class GenerateEnvironmentConfig extends Command
{
    protected $envars = [
        'APP_ENV' => 'local',
        'APP_DEBUG' => 'true',
        'APP_KEY' => '',
        'APP_TIMEZONE' => 'UTC',
        'LOG_CHANNEL' => '',
        'LOG_SLACK_WEBHOOK_URL' => '',
        'DB_CONNECTION' => 'mysql',
        'DB_HOST' => '127.0.0.1',
        'DB_PORT' => '3306',
        'DB_DATABASE' => '',
        'DB_USERNAME' => '',
        'DB_PASSWORD' => '',
        'CACHE_DRIVER' => '',
        'QUEUE_DRIVER' => '',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:env';

    /**
     * The console command description
     *
     * @var string
     */
    protected $description = 'generate environment file';

    protected $file;

    protected $filepath;

    /**
     * Create a new command instance.
     *
     * GenerateEnvironmentConfig constructor.
     * @param Filesystem $file
     */
    public function __construct(Filesystem $file) {
        $this->file = $file;
        $this->filepath = base_path() . '.env.default';
        parent::__construct();
    }

    public function handle() {
        $content = '';

        $this->envars['APP_ENV'] = $this->choice('Environment(local, production)? Defaults to local.', ['local', 'production'], 0);
        $this->envars['APP_DEBUG'] = $this->choice('Enable debug mode(true, false)? Defaults to true.', ['true', 'false'], 0);
        $this->envars['APP_KEY'] = str_random(32);

        $this->envars['DB_CONNECTION'] = $this->choice('DB Connection? defaults to mysql', ['mysql'], 0);
        $this->envars['DB_HOST'] = $this->ask('Database host ?', '');
        $this->envars['DB_DATABASE'] = $this->ask('Database name ?', '');
        $this->envars['DB_USERNAME'] = $this->ask('Database username ?', '');
        $this->envars['DB_PASSWORD'] = $this->ask('Database password ?', '');

        $this->filepath = base_path() . DIRECTORY_SEPARATOR . '.env.' . $this->envars['APP_ENV'];

        foreach ($this->envars as $key => $value) {
            $content .= $key . '=' . $value . "\n";
        }
        $this->file->put($this->filepath, $content);
    }
}