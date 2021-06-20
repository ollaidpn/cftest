<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams=Team::orderByDesc('id')->get();
        $organizations = Organization::orderBy('name')->get();
        return view(Auth::user()->role->slug.'.equipe.index',compact('teams','organizations'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrganizationTeams($id)
    {
        $organization=Organization::find($id);
        if ($organization)
            $teams=$organization->teams;
        else
            return 'organization error';
        return response(["teams" => $teams, "organization" => $organization], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'name'=>'required|string|max:50',
            'organization_id'=>'required',
        ]);

        $team= new Team();
        $team->name = $request->input('name');
        $team->organization_id = $request->input('organization_id');
        if ($team->save()) {
            session()->flash('success', 'Equipe ajouté avec succès !');
        } else {
            session()->flash('error', 'Une erreur est survenu lors de la sauvegarde !');
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Team::where("id",$id)->with('organization')->get()->first();

        if ($team) {
            return response(['team' => $team], 200);
        } else {
            return "team error";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name'=>'required|string|max:50',
            'organization_id'=>'required',
            ]);

        $team= Team::find($id);
        if ($team) {

            $team->name = $request->input('name');
            $team->organization_id = $request->input('organization_id');
        }
        if ($team->update()) {
            session()->flash('success', 'Equipe modifié avec succès !');
        } else {
            session()->flash('error', 'Une erreur est survenu lors de la modification !');
        }
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $team = Team::find($id);

        if ($team) {

            $team->delete();
            session()-> flash('success',"Equipe suppprimer avec succes ");
            return back();
        }
    }
}
