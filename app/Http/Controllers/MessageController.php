<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\Message as MessageForm;

class MessageController extends Controller
{
    /**
     * Thank you message.
     *
     * @var string
     */
    protected $message = 'Thank you for your message. We will get back to you ASAP!';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(MessageForm $request)
    {
        Message::create($request->only(Message::attributes()));

        return success(route('contact'), null, $this->message);
    }
}
