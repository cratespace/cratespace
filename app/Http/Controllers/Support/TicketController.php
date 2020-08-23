<?php

namespace App\Http\Controllers\Support;

use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupportTicketRequest;
use App\Http\Controllers\Support\Concerns\CreatesNewCustomer;

class TicketController extends Controller
{
    use CreatesNewCustomer;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', new Ticket());

        return view('support.tickets.index', [
            'tickets' => Ticket::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('support.tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\SupportTicketRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SupportTicketRequest $request)
    {
        $ticket = $this->getCustomer($request)
            ->tickets()
            ->create($request->validated());

        return $this->success($ticket->path);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return view('support.tickets.show', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\SupportTicketRequest $request
     * @param \App\Models\Ticket                      $ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SupportTicketRequest $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->update($request->validated());

        return $this->success($ticket->path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Ticket $ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();

        return $this->success(route('tickets.index'));
    }
}
