<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PeterColes\Countries\CountriesFacade;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::find(1) ;
        return view(Auth::user()->role->slug.'.settings.users.addUser')->with( 'roles', $roles);
    }

    public function allUser()
    {
        $users =   User::all();
        return view(Auth::user()->role->slug.'.settings.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Ajouter un utilisateur";
        $countries = CountriesFacade::lookup('fr_FR');
        $organizations = Organization::orderBy('name')->get();
        $roles = Role::orderBy('title')->get();
        return view(Auth::user()->role->slug.'.settings.users.addUser', compact('countries', 'organizations', 'roles', 'page_title'));
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
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'gender'=>'required|string|max:7',
            'phone'=>'nullable|string|max:20|unique:users,phone',
            'email'=>'required|email|unique:users,email',
            'role_id'=>'required',

            'country'=>'required|string|max:255',
            'address'=>'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        $user= new User;

        $user->first_name=$request->input('first_name');
        $user->last_name=$request->input('last_name');
        $user->gender=$request->input('gender');
        $user->phone=$request->input('phone');
        $user->country=$request->input('country');
        $user->address=$request->input('address');
        $user->role_id=$request->input('role_id');
        $user->password=Hash::make("@FC2021");
        $user->email=$request->input('email');
        $user->date_of_birth=$request->input('date_of_birth');

        if ($request->hasFile('avatar')) {

            $role = Role::find($request->input('role_id'));
            $avatar_name = time().'.'.$request->avatar->getClientOriginalExtension();
            $path_name = 'uploads/'.$role->slug.'/avatar'."/". date('Y')."/". date('F'). '/';
            if ($request->avatar->move("storage/".$path_name, $avatar_name)) {
                $user->avatar = $path_name.$avatar_name;
            }
        }

        if ($user->save()) {
            session()->flash('success', 'Utilisateur ajouté avec succès !');
        } else {
            session()->flash('error', 'Une erreur est survenu lors de la sauvegarde !');
        }

        return back();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profil() {

        $page_title = "Profil";
        $user = Auth::user();
        $countries = CountriesFacade::lookup('fr_FR');
        $roles = Role::orderBy('title')->get();

        return view(Auth::user()->role->slug.'.settings.profile', compact('user', 'page_title', 'countries', 'roles'));
    }

    public function edit($id)
    {
        $roles = Role::all() ;

        $page_title = 'Modifier responsable pédagogique';
        $educational_admin = User::find($id);
        $countries = CountriesFacade::lookup('fr_FR');
        if ($educational_admin) {
            return view(Auth::user()->role->slug.'.settings.users.edit', compact('educational_admin', 'countries', 'page_title', 'roles'));
        }

    }


    public function update(Request $request, $id)
    {
        $page_title = 'Tous les responsables pédagogiques';

        $this->validate($request, [
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'gender'=>'required|string|max:7',
            'phone'=>'nullable|string|max:20|unique:users,phone,'.$id,
            'email'=>'required|email|unique:users,email,'.$id,
            'country'=>'required|string|max:255',
            'address'=>'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'role_id'=>'required|string|max:255',


        ]);

        $user= User::find($id);
        if ($user) {

            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->gender = $request->input('gender');

            $user->phone = $request->input('phone');
            $user->country = $request->input('country');
            $user->address = $request->input('address');

            $user->role_id =$request->input('role_id');
            $user->password = Hash::make("@FC2020");

            $user->email = $request->input('email');
            $user->date_of_birth = $request->input('date_of_birth');

            if ($request->hasFile('avatar')) {

                $user->avatar ? File::delete(public_path($user->avatar)) : '';
                $avatar_name = time().'.'.$request->avatar->getClientOriginalExtension();
                $path_name = 'uploads/educational-admin/avatar'."/". date('Y')."/". date('F'). '/';
                if ($request->avatar->move("storage/".$path_name, $avatar_name)) {
                    $user->avatar = $path_name.$avatar_name;
                }

            }

            $user->update();
            return back()->with('success', 'Responsable Pédagogiques modifié avec succès !');


        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateProfil(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'gender'=>'required|string|max:7',
            'phone'=>'nullable|string|max:20|unique:users,phone,'.Auth::user()->id,
            'email'=>'required|email|unique:users,email,'.Auth::user()->id,
            'country'=>'required|string|max:255',
            'address'=>'required|string|max:255',
            'password'=> !$request->actual_password ? 'nullable' : 'required'.'|string|max:255|min:8|confirmed',
            'actual_password'=> !$request->actual_password ? 'nullable' : 'required'.'|string|max:255|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        $user = User::find(Auth::user()->id);
        if ($user) {

            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->gender = $request->input('gender');

            $user->phone = $request->input('phone');
            $user->country = $request->input('country');
            $user->address = $request->input('address');

            $role = Role::find($user->role_id);
            if ($role->slug === 'admin')
                $user->role_id = $request->role_id;

            if ($request->actual_password && Hash::check($request->actual_password, $user->password)) {

                $user->password = Hash::make($request->password);
            } else if ($request->actual_password && !Hash::check($request->actual_password, $user->password)) {

                session()->flash('error', 'Le mot de passe actuel que vous avez saisi est incorrect.');
                return back();
            }

            $user->email = $request->input('email');
            $user->date_of_birth = $request->input('date_of_birth');

            if ($request->hasFile('avatar')) {

                $user->avatar ? File::delete(public_path($user->avatar)) : '';
                $avatar_name = time().'.'.$request->avatar->getClientOriginalExtension();
                $path_name = 'uploads/'. $role->slug .'/avatar'."/". date('Y')."/". date('F'). '/';
                if ($request->avatar->move("storage/".$path_name, $avatar_name)) {
                    $user->avatar = $path_name.$avatar_name;
                }

            }

            if ($user->update()) {
                session()->flash('success', 'Profil modifié avec succès !');
            } else {
                session()->flash('error', 'Une erreur est survenu lors de la modification !');
            }

            return back();

        } else {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
