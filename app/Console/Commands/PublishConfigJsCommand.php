<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PublishConfigJsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'configjs:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish application configurations for usage inside JavaScript.';

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
    public function handle()
    {
        $this->publishConfigJs();

        $this->line('Configurations published for use with JavaScript');

        return 0;
    }

    /**
     * Publish application configurations to JSON file to be used by SPA.
     *
     * @return void
     */
    protected function publishConfigJs(): void
    {
        if (! file_exists($configJsFile = resource_path('js/Config/items.json'))) {
            @touch($configJsFile);
        }

        file_put_contents($configJsFile, json_encode(config()->all()));
    }
}
