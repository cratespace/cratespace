<?php

namespace App\Models\Concerns;

use App\Support\Concerns\InteractsWithContainer;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

trait InteractsWithSessions
{
    use InteractsWithContainer;

    /**
     * Get user sessions details.
     *
     * @return array
     */
    public function getSessionsAttribute(): array
    {
        return $this->sessions($this->resolve('request'))->all();
    }

    /**
     * Get the current sessions.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Support\Collection
     */
    public function sessions(Request $request): Collection
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::table(config('session.table', 'sessions'))
                ->where('user_id', $this->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function (?Session $session = null) use ($request): object {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp(
                    $session->last_activity
                )->diffForHumans(),
            ];
        });
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param mixed $session
     *
     * @return \Jenssegers\Agent\Agent
     */
    protected function createAgent($session): Agent
    {
        return tap(new Agent(), function (Agent $agent) use ($session): void {
            $agent->setUserAgent($session->user_agent);
        });
    }
}
