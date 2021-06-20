<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use PeterColes\Countries\CountriesFacade;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $page_title = "Toutes les organisations";
        $organizations=Organization::orderByDesc('id')->paginate(8);

        return view(Auth::user()->role->slug.'.organization.index', compact('organizations', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Ajouter une organisation";
        $countries = CountriesFacade::lookup('fr_FR');
        $organizations = Organization::orderBy('name')->get();
        return view(Auth::user()->role->slug.'.organization.ajouter-organismes', compact('countries', 'organizations', 'page_title'));
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

            'name'=>'required|string|unique:organizations,name',
            'phone'=>'required|string|unique:organizations,phone',
            'address'=>'required|string',
            'description'=>'nullable|string',
            'logo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024'

        ]);

        $organization= new Organization();
        $organization->name=$request->input('name');
        $organization->phone=$request->input('phone');
        $organization->address=$request->input('address');
        $organization->description=$request->input('description');
        $organization->slug=Str::slug($organization->name);
        // dd($organization->slug);

        if ($request->hasFile('logo')) {

            $logo_name = time().'.'.$request->logo->getClientOriginalExtension();
            $path_name = 'uploads/organizations/logo'."/". date('Y')."/". date('F'). '/';
            if ($request->logo->move("storage/".$path_name, $logo_name)) {
                $organization->logo = $path_name.$logo_name;
            }

        }

        if($organization->save()){
            session()-> flash('success',"Organisme ajouter avec succes ");
        }else{
            session()->flash('error','une erreur est survenu lors de creation.');
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organization = Organization::where('id', $id)->with('teams')->get()->first();

        if ($organization) {
            return response(['organization' => $organization], 200);
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = "Modifier une organisation";
        $organization = Organization::find($id);
        if ($organization)
            return view(Auth::user()->role->slug.'.organization.edit', compact('organization', 'page_title'));
        else
            abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page_title = "Toutes les organisations";

        $this->validate($request, [

            'name'=>'required|string|unique:organizations,name,'.$id,
            'phone'=>'required|string|unique:organizations,phone,'.$id,
            'address'=>'required|string',
            'description'=>'nullable|string',
            'logo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024'

        ]);

        $organization = Organization::find($id);
        if ($organization) {
            $organization->name=$request->input('name');
            $organization->phone=$request->input('phone');
            $organization->address=$request->input('address');
            $organization->description=$request->input('description');
            $organization->slug=Str::slug($request->title);

            if ($request->hasFile('logo')) {

                $organization->logo ? File::delete(public_path($organization->logo)) : '';
                $logo_name = time().'.'.$request->logo->getClientOriginalExtension();
                $path_name = 'uploads/organizations/logo'."/". date('Y')."/". date('F'). '/';
                if ($request->logo->move("storage/".$path_name, $logo_name)) {
                    $organization->logo = $path_name.$logo_name;
                }

            }

            if($organization->update()){
                session()-> flash('success',"Organisme mise à jour avec succes ");
            }else{
                session()->flash('error','une erreur est survenu lors de creation.');
            }

            $organizations=Organization::orderByDesc('id')->paginate(8);

            return view(Auth::user()->role->slug.'.organization.index', compact('organizations', 'page_title'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        $organization = Organization::find($id);

        if ($organization) {
            $organization->delete();
            session()-> flash('success',"Organisme suppprimer avec succes ");
            return back();
        } else {
            abort(404);
        }
    }
}
