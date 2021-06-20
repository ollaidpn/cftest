<?php

namespace App\Http\Controllers;

use App\Models\MsgVisitor;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class MsgVisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = MsgVisitor::all();
        return view(Auth::user()->role->slug.'.message.message',compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\msgVisitor  $msgVisitor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $messages = msgVisitor::where('id', $id)->get()->first();

        if ($messages) {
            return response(['msg_visitors' => $messages], 200);
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\msgVisitor  $msgVisitor
     * @return \Illuminate\Http\Response
     */
    public function edit(msgVisitor $msgVisitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\msgVisitor  $msgVisitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, msgVisitor $msgVisitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\msgVisitor  $msgVisitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(msgVisitor $msgVisitor)
    {
        //
    }
}
