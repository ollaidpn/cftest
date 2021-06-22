<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use PeterColes\Countries\CountriesFacade;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Tous les formateurs';

        $users= User::orderByDesc('id')->whereHas('role', function ($q)
        {
            $q->where('slug', 'teacher');
        })->get();

        return view(Auth::user()->role->slug.'.teacher.formateurs', compact('users', 'page_title'));
    }
    public function dashboard () {
        $page_title = "Tableau de bord";

        return view(Auth::user()->role->slug.'.index', compact('page_title'));
    }

    public function delete($id)
    {
        $teacher = User::find($id);

        if ($teacher) {

            $teacher->delete();
            session()-> flash('success',"Formateur suppprimé avec succès ");
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Ajouter un formateur';
        $countries = CountriesFacade::lookup('fr_FR');

        return view(Auth::user()->role->slug.'.teacher.addFormateurs', compact('countries', 'page_title'));
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
            'phone'=>'nullable',
            'email'=>'required|email|unique:users,email',
            'country'=>'required|string|max:255',
            'address'=>'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        $user= new User;

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->gender = $request->input('gender');

        $user->phone = $request->input('phone');
        $user->country = $request->input('country');
        $user->address = $request->input('address');

        $role = Role::where('slug', 'teacher')->get()->first();
        $user->role_id = $role->id;
        $user->password = Hash::make("@FC2020");

        $user->email = $request->input('email');
        $user->date_of_birth = $request->input('date_of_birth');

        if ($request->hasFile('avatar')) {

            $avatar_name = time().'.'.$request->avatar->getClientOriginalExtension();
            $path_name = 'uploads/teachers/avatar'."/". date('Y')."/". date('F'). '/';
            if ($request->avatar->move("storage/".$path_name, $avatar_name)) {
                $user->avatar = $path_name.$avatar_name;
            }
        }

        if ($user->save()) {
            session()->flash('success', 'Formateur ajouté avec succès !');
        } else {
            session()->flash('error', 'Une erreur est survenu lors de la sauvegarde !');
        }

        return back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = User::where('id', $id)->get()->first();

        if ($teacher) {
            return response(['teacher' => $teacher], 200);
        } else {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Modifier un formateur';
        $teacher = User::find($id);
        $countries = CountriesFacade::lookup('fr_FR');
        if ($teacher) {
            return view(Auth::user()->role->slug.'.teacher.editFormateur', compact('teacher', 'countries', 'page_title'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page_title = 'Tous les formateurs';

        $this->validate($request, [
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'gender'=>'required|string|max:7',
            'phone'=>'nullable|string|max:20|unique:users,phone,'.$id,
            'email'=>'required|email|unique:users,email,'.$id,
            'country'=>'required|string|max:255',
            'address'=>'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        $user= User::find($id);
        if ($user) {

            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->gender = $request->input('gender');

            $user->phone = $request->input('phone');
            $user->country = $request->input('country');
            $user->address = $request->input('address');

            $role = Role::where('slug', 'teacher')->get()->first();
            $user->role_id = $role->id;
            $user->password = Hash::make("@FC2020");

            $user->email = $request->input('email');
            $user->date_of_birth = $request->input('date_of_birth');

            if ($request->hasFile('avatar')) {

                $user->avatar ? File::delete(public_path($user->avatar)) : '';
                $avatar_name = time().'.'.$request->avatar->getClientOriginalExtension();
                $path_name = 'uploads/teachers/avatar'."/". date('Y')."/". date('F'). '/';
                if ($request->avatar->move("storage/".$path_name, $avatar_name)) {
                    $user->avatar = $path_name.$avatar_name;
                }

            }

            if ($user->update()) {
                session()->flash('success', 'Formateurs modifié avec succès !');
            } else {
                session()->flash('error', 'Une erreur est survenu lors de la modification !');
            }

            $users= User::orderByDesc('id')->whereHas('role', function ($q){
                                $q->where('slug', 'teacher');
                            })->get();

            return view(Auth::user()->role->slug.'.teacher.formateurs', compact('users', 'page_title'));

        } else {
            abort(404);
        }
    }
}
