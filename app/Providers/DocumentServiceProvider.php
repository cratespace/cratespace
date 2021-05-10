<?php

namespace App\Providers;

use App\Documents\Document;
use App\Documents\MarkdownDocument;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;

class DocumentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDocumentationManager();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register documentation manager.
     *
     * @return void
     */
    public function registerDocumentationManager(): void
    {
        $this->app->singleton(Document::class, function (): Document {
            $manager = new MarkdownDocument();

            $manager->createEnvironment();

            $manager->addExtension(
                new GithubFlavoredMarkdownExtension()
            );

            return $manager;
        });
    }
}
