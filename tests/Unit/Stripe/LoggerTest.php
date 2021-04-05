<?php

namespace Tests\Unit\Stripe;

use Mockery as m;
use Psr\Log\LoggerInterface;
use App\Services\Stripe\Logger;
use PHPUnit\Framework\TestCase;
use Stripe\Util\LoggerInterface as StripeLoggerInterface;

class LoggerTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testInstantiation()
    {
        $logger = new Logger(m::mock(LoggerInterface::class));

        $this->assertInstanceOf(StripeLoggerInterface::class, $logger);
    }

    public function testErrorLog()
    {
        $psrLogger = m::mock(LoggerInterface::class);
        $psrLogger->shouldReceive('error')
            ->once()
            ->with('Error message.', []);
        $logger = new Logger($psrLogger);
        $log = $logger->error('Error message.', []);

        $this->assertNull($log);
    }
}
