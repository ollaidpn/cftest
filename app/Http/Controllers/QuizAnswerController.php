<?php

namespace App\Http\Controllers;

use App\Models\QuizAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(Auth::user()->role->slug.'.quizz.answers');
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
     * @param  \App\Models\QuizAnswer  $quizAnswer
     * @return \Illuminate\Http\Response
     */
    public function show(QuizAnswer $quizAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuizAnswer  $quizAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(QuizAnswer $quizAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuizAnswer  $quizAnswer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizAnswer $quizAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuizAnswer  $quizAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizAnswer $quizAnswer)
    {
        //
    }
}
