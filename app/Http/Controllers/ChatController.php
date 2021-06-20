<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,
        [
            'message'=>'required|string|max:255',
            'pj' =>  'nullable' .'|image|mimes:jpeg,png,jpg,gif,svg|max:1024',

        ]);

        $message = new Chat();

        $message->message=$request->input('message');
        $message->system_email=$request->input('system_email');


        if ($request->hasFile('pj')) {

            $file_name = time().'.'.$request->pj->getClientOriginalExtension();
            $path_name = 'storage/uploads/system/'. date('Y')."/". date('F'). '/';

            if ($request->pj->move($path_name, $file_name)) {
                $message->pj = $path_name.$file_name;
            }

        }



        $message->save->flash('success', 'Information mise à jour avec succès !');
        return view(Auth::user()->role->slug.'.settings.index', compact('infosSystems', 'page_title'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
