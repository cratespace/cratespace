<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Space;
use App\Filters\SpaceFilter;
use App\Listings\SpaceListing;
use App\Http\Services\IpIdentifier;

class SpaceListingsTest extends TestCase
{
    /** @test */
    public function it_only_gets_spaces_based_on_customers_ip_location()
    {
        $this->withoutExceptionHandling();

        $_SERVER['REMOTE_ADDR'] = '66.102.0.0';

        $local = create(Space::class, [
            'base' => 'United States'
        ]);

        $this->assertEquals($local->base, $this->listings()->first()->base);

        unset($_SERVER['REMOTE_ADDR']);
        $_SERVER['REMOTE_ADDR'] = null;
    }

    /** @test */
    public function it_defaults_to_show_spaces_from_sri_lanka_if_valid_ip_was_not_obtained()
    {
        $this->unsetGlobals();

        $local = create(Space::class, [
            'base' => 'Sri Lanka'
        ]);

        $this->assertEquals($local->base, $this->listings()->first()->base);

        if (isset($_SERVER['REMOTE_ADDR'])) {
            unset($_SERVER['REMOTE_ADDR']);
            $_SERVER['REMOTE_ADDR'] = null;
        }
    }

    /**
     * Get listings.
     *
     * @param  boolean $state
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function listings()
    {
        return (new SpaceListing(new Space))->get(new SpaceFilter(request()));
    }

    /**
     * Unset global server variables.
     */
    protected function unsetGlobals()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            unset($_SERVER['HTTP_CLIENT_IP']);
            $_SERVER['HTTP_CLIENT_IP'] = null;
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            unset($_SERVER['HTTP_X_FORWARDED_FOR']);
            $_SERVER['HTTP_X_FORWARDED_FOR'] = null;
        }

        if (isset($_SERVER['REMOTE_ADDR'])) {
            unset($_SERVER['REMOTE_ADDR']);
            $_SERVER['REMOTE_ADDR'] = null;
        }
    }
}
