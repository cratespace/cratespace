<?php

namespace Tests\Unit\Stripe;

use Mockery as m;
use Stripe\Stripe;
use Tests\TestCase;
use Psr\Log\LoggerInterface;
use App\Services\Stripe\Logger;
use Stripe\Util\LoggerInterface as StripeLoggerInterface;

/**
 * @group Stripe
 */
class LoggerTest extends TestCase
{
    protected function tearDown(): void
    {
        config(['billing.logger' => null]);

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

    public function testTheLoggerUsesALogChannel()
    {
        $channel = m::mock(LoggerInterface::class);
        $channel->shouldReceive('error')
            ->once()
            ->with('foo', ['bar']);

        $this->mock('log', function ($logger) use ($channel) {
            $logger->shouldReceive('channel')
                ->with('default')
                ->once()
                ->andReturn($channel);
        });

        config(['billing.services.stripe.logger' => 'default']);

        $logger = $this->app->make(StripeLoggerInterface::class);

        $log = $logger->error('foo', ['bar']);

        $this->assertNull($log);
    }

    public function testItUsesAConfiguredLogger()
    {
        $this->channel = 'default';

        $this->refreshApplication();

        $logger = Stripe::getLogger();

        $this->assertInstanceOf(
            Logger::class,
            $logger,
            'Failed asserting that Stripe uses the native logger.'
        );
    }
}
