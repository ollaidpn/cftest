<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Toutes les formations";
        $user= Auth::user();
        if ($user->role->slug==='admin' || $user->role->slug==='educational-admin') {

            $formations = Formation::orderByDesc('id')->paginate(9);
        }
        else{

            $formations=paginate($user->formations, 9);
        }
        return view(Auth::user()->role->slug.'.formation.courses', compact('formations', 'page_title'));
    }

    public function indexP()
    {
        $page_title = "Toutes les formations";
        $user= Auth::user();
        if ($user->role->slug==='admin' || $user->role->slug==='educational-admin') {

            $formations = Formation::orderByDesc('id')->paginate(9);
        }
        else{

            $formations=paginate($user->formations, 9);
        }
        return view('educational-admin.formation.courses', compact('formations', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Ajouter une formation";
        return view(Auth::user()->role->slug.'.formation.create', compact('page_title'));
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
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function show(Formation $formation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function edit(Formation $formation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function udpate($id)
    {
        $page_title = "Modifier une formation";

        $formation = Formation::where('id',$id)->with('teams')->get()->first();

        if (!$formation) {
            abort(404);
        }

        return view(Auth::user()->role->slug.'.formation.update', compact('formation', 'page_title'));
    }

    public function udpateP($id)
    {
        $page_title = "Modifier une formatioffn";

        $formation = Formation::where('id',$id)->with('teams')->get()->first();

        return view('educational-admin.formation.update', compact('formation', 'page_title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page_title = "Toutes les formations";

        $formation = Formation::find($id);
        if (!$formation)
            abort(404);
        else
            $formation->delete();

        $formations = Formation::orderByDesc('id')->paginate(9);
        session()->flash('success', 'Formation supprimé avec succès');

        return view(Auth::user()->role->slug.'.formation.courses', compact('formations', 'page_title'));
    }
}
