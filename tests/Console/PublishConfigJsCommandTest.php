<?php

namespace Tests\Console;

use Tests\TestCase;
use Tests\Concerns\InteractsWithFiles;
use App\Console\Commands\PublishConfigJsCommand;

class PublishConfigJsCommandTest extends TestCase
{
    use InteractsWithFiles;

    /**
     * JS config items file.
     *
     * @var string
     */
    protected $items;

    public function setUp(): void
    {
        parent::setUp();

        PublishConfigJsCommand::setConfigFile('test.json');

        $this->items = resource_path('js/Config/test.json');

        $this->deleteFile($this->items);
    }

    protected function tearDown(): void
    {
        $this->deleteFile($this->items);
    }

    public function testPublishConfigAsJsonFile()
    {
        $this->artisan('cs:configjs')
            ->expectsOutput('Config items published to json file [test.json].')
            ->assertExitCode(0);

        $this->assertTrue(file_exists($this->items));
    }
}
