<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Facades\App\Calculators\Purchase;
use Illuminate\Cache\CacheManager as Cache;

class CheckoutController extends Controller
{
    /**
     * Instance of cache.
     *
     * @var \Illuminate\Cache\Cache
     */
    protected $cache;

    /**
     * Create new checkout controller instance.
     */
    public function __construct(Cache $cache)
    {
        $this->middleware('purchase')->only(['show', 'destroy']);

        $this->cache = $cache;
    }

    /**
     * Show checkout page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('checkout', [
            'space' => $this->cache->get('space') ?? new Space(),
            'pricing' => Purchase::calculate($this->cache->get('space')->price)
                ->getAmounts(),
        ]);
    }

    /**
     * Calculate prices and redirect to checkout page.
     *
     * @param \App\Models\Space $space
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Space $space)
    {
        $this->cache->put('space', $space);

        return redirect()->route('checkout');
    }

    /**
     * Cancel purchase and redirect to listings.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        $this->cache->flush();

        return redirect()->route('welcome');
    }
}
