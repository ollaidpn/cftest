<?php

namespace App\Http\Controllers;

use App\Models\Enrollement;
use App\Models\Formation;
use App\Models\FormationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EnrollementController extends Controller
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
    public function paye()
    {

        if (isset($_GET['token'])) {
            $data = check_paydunya_invoice();
            if ($data['status'] == 'completed') {
                $Enrollement = session('Enrollement');
                if ($Enrollement && $Enrollement->save()) {
                    $url = $data['receipt_link'];
                    session()->flash('success', "Félicitations,vous venez d'acheter ce cours ! <br> Votre facture est disponible sur ce lien <a href='$url' > ICI </a>   ");
                }
            }
        }


        return back();


    }

    // public function addToCart(Request $request)
    // {
    //     {
    //         $this->validate($request, [

    //             'formation_id'=>'required',
    //             'montant'=>'required',





    //         ]);
    //         $addToCart= new Enrollement();

    //         $addToCart->user_id=Auth::user()->id;
    //         $addToCart->formation_id=$request->input('formation_id');
    //         $addToCart->montant=$request->input('montant');

    //         $addToCart->save();
    //         return back()->with('success', 'Cours ajouté au panier !');
    //     }
    // }


    public function store(Request $request)
    {
        {
            $this->validate($request, [

                'formation_id'=>'required',






            ]);
            $Enrollement= new FormationUser();

            $Enrollement->user_id=Auth::user()->id;
            $Enrollement->status="payé";

            $Enrollement->formation_id=$request->input('formation_id');
            $formation = Formation::find($Enrollement->formation_id);
            paydunya_config(url()->previous(), url()->previous());

            $invoice = new \Paydunya\Checkout\CheckoutInvoice();
            $invoice->addItem($formation->title, 1,  $formation->price,  $formation->price*1);
            $invoice->setTotalAmount($formation->price);
            session()->flash('Enrollement', $Enrollement);
            if($invoice->create()) {
                return Redirect::to($invoice->getInvoiceUrl());
            }else{
                echo $invoice->response_text;
            }


            // $Enrollement->save();
            // return back()->with('success', 'Enrollement Envoyé !');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enrollement  $enrollement
     * @return \Illuminate\Http\Response
     */
    public function show(Enrollement $enrollement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enrollement  $enrollement
     * @return \Illuminate\Http\Response
     */
    public function edit(Enrollement $enrollement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enrollement  $enrollement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enrollement $enrollement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enrollement  $enrollement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enrollement $enrollement)
    {
        //
    }
}
