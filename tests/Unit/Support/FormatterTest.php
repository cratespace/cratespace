<?php

namespace Tests\Unit\Support;

use App\Support\Formatter;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    /** @test */
    public function it_can_convert_string_price_values_into_integers()
    {
        $amount = Formatter::getIntegerValues('$45.12');

        $this->assertEquals(4512, $amount);
    }

    /** @test */
    public function it_can_parse_markdown_content_to_html()
    {
        $content = file_get_contents(__DIR__ . '/fixtures/stub.md');

        $content = Formatter::markdown($content);

        $expectedMarkdown = "<h1>FooBar Title</h1>\n<p>The most foobary content ever!</p>";

        $this->assertEquals($expectedMarkdown, $content);
    }

    /** @test */
    public function it_can_extract_an_excerpt_of_a_paragraph()
    {
        $originalContent = 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.';

        $expectedContent = 'Cum sociis natoque penatibus et magnis dis...';

        $content = Formatter::excerpt($expectedContent, 50);

        $this->assertEquals($expectedContent, $content);
    }
}
