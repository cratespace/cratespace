<?php

namespace App\Documents;

use League\CommonMark\Environment;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\EnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;

class MarkdownDocument extends Document
{
    /**
     * The markdown converter environment manager.
     *
     * @var \League\CommonMark\EnvironmentInterface
     */
    protected $environment;

    /**
     * Convert given markdown content to HTML.
     *
     * @param string $contents
     *
     * @return string
     */
    public function convertToHtml(string $contents): string
    {
        return $this->converter()->convertToHtml($contents);
    }

    /**
     * Get instance of Markdown converter.
     *
     * @param array                                        $config
     * @param \League\CommonMark\EnvironmentInterface|null $environment
     *
     * @return \League\CommonMark\CommonMarkConverter
     */
    public function converter(
        array $config = [],
        ?EnvironmentInterface $environment = null
    ): CommonMarkConverter {
        return new CommonMarkConverter(
            $config,
            $environment ?? $this->environment
        );
    }

    /**
     * Undocumented function.
     *
     * @param \League\CommonMark\ExtensionInterface $extension
     *
     * @return \App\Documents\Document
     */
    public function addExtension(ExtensionInterface $extension): Document
    {
        $this->environment->addExtension($extension);

        return $this;
    }

    /**
     * Create Markdown converter environment manager.
     *
     * @return \App\Documents\Document
     */
    public function createEnvironment(): Document
    {
        $this->environment = Environment::createCommonMarkEnvironment();

        return $this;
    }
}
