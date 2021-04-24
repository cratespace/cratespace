<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PublishConfigJsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cs:configjs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish application configuration to json file for usage with JavaScript.';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Path to where config 'items' file should be located.
     *
     * @var string
     */
    protected $configPath;

    /**
     * Config JSON file.
     *
     * @var string
     */
    protected static $configFile = 'items.json';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
        $this->configPath = resource_path('js/Config');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->publishConfigJs();

        $file = static::getConfigFile();

        $this->info("Config items published to json file [{$file}].");

        return 0;
    }

    /**
     * Publish application configuration to json file for usage with JavaScript.
     *
     * @return void
     */
    protected function publishConfigJs(): void
    {
        if (! $this->files->isDirectory($this->configPath)) {
            $this->files->makeDirectory($this->configPath, 0777, true);
        }

        $configItems = $this->configPath . \DIRECTORY_SEPARATOR . static::getConfigFile();

        if (! $this->files->exists($configItems)) {
            \touch($configItems);
        }

        $this->files->put($configItems, json_encode(config()->all()));
    }

    /**
     * Get name of file where all configurations will be published.
     *
     * @return string
     */
    public static function getConfigFile(): string
    {
        return static::$configFile;
    }

    /**
     * Set the name of the file where all configurations will be published to.
     *
     * @param string $file
     *
     * @return void
     */
    public static function setConfigFile(string $file): void
    {
        static::$configFile = $file;
    }
}
