<?php

namespace App\Http\Controllers\Support;

use App\Models\Reply;
use App\Models\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupportTicketReplyRequest;

class TicketReplyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\SupportTicketReplyRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SupportTicketReplyRequest $request, Ticket $ticket)
    {
        if ($ticket->marked('Closed')) {
            return $this->unAuthorizedJson('Ticket has been closed');
        }

        $ticket->addReply($request->validated());

        return $this->success($ticket->path);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\SupportTicketReplyRequest $request
     * @param \App\Models\Reply                            $reply
     *
     * @return \Illuminate\Http\Response
     */
    public function update(SupportTicketReplyRequest $request, Reply $reply)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Reply $reply
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
    }
}
