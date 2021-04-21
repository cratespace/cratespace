<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Middleware\EnsureFrontendRequestsAreStateful;

class EnsureFrontendRequestsAreStatefulTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('api.stateful', ['test.com', '*.test.com']);
    }

    public function testRequestRefererIsParsedAgainstConfiguration()
    {
        $request = Request::create('/');
        $request->headers->set('referer', 'https://test.com');

        $this->assertTrue(EnsureFrontendRequestsAreStateful::fromFrontend($request));

        $request = Request::create('/');
        $request->headers->set('referer', 'https://wrong.com');

        $this->assertFalse(EnsureFrontendRequestsAreStateful::fromFrontend($request));

        $request = Request::create('/');
        $request->headers->set('referer', 'https://test.com.x');

        $this->assertFalse(EnsureFrontendRequestsAreStateful::fromFrontend($request));

        $request = Request::create('/');
        $request->headers->set('referer', 'https://foobar.test.com/');

        $this->assertTrue(EnsureFrontendRequestsAreStateful::fromFrontend($request));
    }

    public function testRequestOriginFallback()
    {
        $request = Request::create('/');
        $request->headers->set('origin', 'test.com');

        $this->assertTrue(EnsureFrontendRequestsAreStateful::fromFrontend($request));

        $request = Request::create('/');
        $request->headers->set('referer', null);
        $request->headers->set('origin', 'test.com');

        $this->assertTrue(EnsureFrontendRequestsAreStateful::fromFrontend($request));

        $request = Request::create('/');
        $request->headers->set('referer', '');
        $request->headers->set('origin', 'test.com');

        $this->assertTrue(EnsureFrontendRequestsAreStateful::fromFrontend($request));
    }

    public function testWildcardMatching()
    {
        $request = Request::create('/');
        $request->headers->set('referer', 'https://foo.test.com');

        $this->assertTrue(EnsureFrontendRequestsAreStateful::fromFrontend($request));
    }

    public function testRequestsAreNotStatefulWithoutReferer()
    {
        $this->app['config']->set('api.stateful', ['']);

        $request = Request::create('/');

        $this->assertFalse(EnsureFrontendRequestsAreStateful::fromFrontend($request));
    }
}
