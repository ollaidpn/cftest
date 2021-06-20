<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
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
    public function addToCart(Request $request)
    {
        {
            $this->validate($request, [

                'formation_id'=>'required',
                'montant'=>'required',





            ]);
            $addToCart= new Cart();

            $addToCart->user_id=Auth::user()->id;
            $addToCart->formation_id=$request->input('formation_id');
            $addToCart->montant=$request->input('montant');

            $addToCart->save();
            return back()->with('success', 'Cours ajouté au panier !');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $Cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $Cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $Cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $Cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $Cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $Cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $Cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $Cart)
    {
        //
    }
}
