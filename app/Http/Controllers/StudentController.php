<?php

namespace App\Http\Controllers;
use App\Models\Enrollement;

use App\Models\Formation;
use App\Models\FormationTeam;
use App\Models\FormationUser;
use App\Models\Organization;
use App\Models\Role;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use PeterColes\Countries\CountriesFacade;


class StudentController extends Controller
{
    public function dashboard(){
        $countAMC = FormationUser::where('user_id', Auth::user()->id)->count();
        $FIP = FormationUser::where('user_id', Auth::user()->id)->where('status', 'in process')->count();
        $FF = FormationUser::where('user_id', Auth::user()->id)->where('status', 'finished')->count();

        $test = DB::table('team_user')->where('user_id', Auth::user()->id)->get()->first();
        // $UserTeamID = $test->team_id;
        // $PrivateFormationID = DB::table('formation_team')->select('formation_id')->where('team_id', $UserTeamID)->get();
        // $PrivateFormation = Formation::whereIn('id', $PrivateFormationID)->get();
        // dd($PrivateFormationID);
        // $myTeam = TeamUser::where('user_id', Auth::user()->id)(->get();
        // $privateCount = FormationTeam::where('');
        $page_title = 'Tableau de bord';
        // dd($myTeam);
        return view('student.index', compact('page_title', 'FIP', 'FF', 'countAMC'));
    }

    public function delete($id)
    {
        $student = User::find($id);

        if ($student) {

            $student->delete();
            session()-> flash('success',"Apprenant suppprimer avec succes ");

            return back();
        }
    }

    public function myCourses(){

        $page_title = 'Mes cours';
        $user = Auth::user();
        $User =  User::find( Auth::user());
        $finished_formations = $user->formations()->where('organization_id', null)
                                                    ->where('status', 'finished')
                                                    ->orderByDesc('id')
                                                    ->paginate(6);

        $in_process_formations = $user->formations()->where('organization_id', null)
                                                    ->where('status', 'in process')
                                                    ->orderByDesc('id')
                                                    ->paginate(6);

        $my_formations = $user->formations()->where('organization_id', null)
                                            ->orderByDesc('id')
                                            ->paginate(6);
        // $idPayedFormation = Enrollement::select('formation_id')->where('user_id',Auth::user()->id)->get();
        // $my_payed_formations = Formation::where('id', $idPayedFormation)->get();
        // // dd($in_process_formations->first()->pivot->process);
        // dd($idPayedFormation);

        // $my_payed_formations = [];

        // foreach ($user->enrollements as $enrollements) {
        //     array_push($my_payed_formations, $enrollements->formation);
        //     // dd($user->enrollements);
        // }
        // dd($my_payed_formations);
        // // dd($my_payed_formations);

        return view('student.formation.myCourses', compact( 'my_formations', 'in_process_formations', 'finished_formations', 'page_title'));
    }

    public function private($slug) {

        $organization = Organization::where('slug', $slug)->get()->first();
        if (!$organization)
            abort(404);

        $page_title = $organization->name;
        $formations = $this->getAuthenticatedUserFormationId();
        $in_process_formations = Auth::user()->formations()->whereIn('formation_id', $formations)
                                                    ->where('status', 'in process')
                                                    ->orderByDesc('id')
                                                    ->paginate(6);

        $finished_formations = Auth::user()->formations()->whereIn('formation_id', $formations)
                                                            ->where('status', 'finished')
                                                            ->orderByDesc('id')
                                                            ->paginate(6);

        $organization_formations = Auth::user()->formations()->whereIn('formation_id', $formations)
                                                            ->orderByDesc('id')
                                                            ->get();

        $organization_formations_id = $organization_formations->map(function($formation) {
            return $formation->id;
        });
        $privateNotStarted = Formation::where('type', "private")->where('id', Auth::user()->id);

        $formations = Formation::find($formations)->whereNotIn('id', $organization_formations_id->toArray());
        $organization_formations = paginate($organization_formations->merge($formations), 6);

        return view('student.formation.private', compact('organization_formations', 'in_process_formations', 'finished_formations', 'page_title'));
    }

    public function takePublicCourses($slug){

        $user = Auth::user();
        $formation = $user->formations()->where('slug', $slug)->get()->first();
        if (!$formation)
            abort(404);
        $page_title = $formation->title;

        return view('student.formation.takeCourse', compact('formation', 'page_title'));
    }

    public function takePrivateCourses($slug){

        $formation = Auth::user()->formations->where('slug', $slug)->first();
        if (!$formation) {
            $formations = $this->getAuthenticatedUserFormationId();
            $formation = Formation::where('slug', $slug)->whereIn("id", $formations)->get()->first();
            if (!$formation)
                abort(404);
        }

        $page_title = $formation->title;

        return view('student.formation.takeCourse', compact('formation', 'page_title'));
    }

    public function search(Request $request){

        $request->validate([ 'search' => 'string' ]);

        $formations = paginate(Auth::user()->formations->filter(function ($formation) use ($request){
                            return str_contains(strtolower($formation->title), strtolower($request->search)) ? $formation : '';
                        }), 6);

        if (count($formations) === 0) {
            $formations = $this->getAuthenticatedUserFormationId();
            $formations = Formation::where('title', 'LIKE', '%'.$request->search.'%')->whereIn("id", $formations)->paginate(6);
            $page_title = "Rechercher: ".$request->search;
        }

        return view('student.formation.search', compact('formations', 'page_title'));
    }

    public function wishlist(){
        $page_title = 'Liste de souhaits';
        return view('student.wishlist.index', compact('page_title'));
    }

    public function settings(){
        $page_title = 'Profil';
        $student=Auth::user();
        $countries = CountriesFacade::lookup('fr_FR');
        return view('student.setting.index', compact('student', 'countries', 'page_title'));

    }

    public function index(){
        $page_title = 'Tous les apprenants';

        $users = User::whereHas('role', function ($q) {
                        $q->where('slug', 'student');
                    })->orderByDesc('id')->get();

        return view(Auth::user()->role->slug.'.student.apprenants', compact('page_title', 'users'));
    }

    public function create()
    {
        $page_title = "Ajouter un apprenant";
        $countries = CountriesFacade::lookup('fr_FR');
        $organizations = Organization::orderBy('name')->get();
        return view(Auth::user()->role->slug.'.student.addApprenants', compact('countries', 'organizations', 'page_title'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'gender'=>'required|string|max:7',
            'phone'=>'nullable|string|max:20|unique:users,phone',
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

        $role = Role::where('slug', 'student')->get()->first();
        $user->role_id = $role->id;
        $user->password = Hash::make("@FC2020");

        $user->email = $request->input('email');
        $user->date_of_birth = $request->input('date_of_birth');

        if ($request->hasFile('avatar')) {

            $avatar_name = time().'.'.$request->avatar->getClientOriginalExtension();
            $path_name = 'uploads/students/avatar'."/". date('Y')."/". date('F'). '/';
            if ($request->avatar->move("storage/".$path_name, $avatar_name)) {
                $user->avatar = $path_name.$avatar_name;
            }
        }

        if ($user->save()) {
            $request->input('teams') ? $user->teams()->attach($request->input('teams')) : '';
            session()->flash('success', 'Apprenant ajouté avec succès !');
        } else {
            session()->flash('error', 'Une erreur est survenu lors de la sauvegarde !');
        }
        return back();
    }

    public function edit($id)
    {
        $page_title = 'Modifier un apprenant';
        $student = User::find($id);
        $countries = CountriesFacade::lookup('fr_FR');
        $organizations = Organization::orderBy('name')->get();
        if ($student) {
            return view(Auth::user()->role->slug.'.student.editApprenants', compact('student', 'countries', 'organizations', 'page_title'));
        }
    }

    public function update(Request $request, $id)
    {
        $page_title = "Tous les apprenants";
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

            $role = Role::where('slug', 'student')->get()->first();
            $user->role_id = $role->id;


            $user->email = $request->input('email');
            $user->date_of_birth = $request->input('date_of_birth');

            if ($request->hasFile('avatar')) {

                $user->avatar ? File::delete(public_path($user->avatar)) : '';
                $avatar_name = time().'.'.$request->avatar->getClientOriginalExtension();
                $path_name = 'uploads/students/avatar'."/". date('Y')."/". date('F'). '/';
                if ($request->avatar->move("storage/".$path_name, $avatar_name)) {
                    $user->avatar = $path_name.$avatar_name;
                }

            }

            if ($user->update()) {
                $request->input('teams') ? $user->teams()->sync($request->input('teams')) : '';
                session()->flash('success', 'Apprenant modifié avec succès !');
            } else {
                session()->flash('error', 'Une erreur est survenu lors de la modification !');
            }

            $users = User::whereHas('role', function ($q) {
                $q->where('slug', 'student');
            })->orderByDesc('id')->get();

            return view(Auth::user()->role->slug.'.student.apprenants', compact('users', 'page_title'));

        } else {
            abort(404);
        }
    }

    public function updateProfil(Request $request)
    {
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

    public function show($id)
    {
        $student = User::where('id', $id)->with('teams')->get()->first();

        if ($student) {
            return response(['student' => $student], 200);
        } else {
            abort(404);
        }
    }

    public function getAuthenticatedUserFormationId()
    {
        $user = Auth::user();
        $formations = $user->teams->flatMap(function($team) {
            return $team->formations;
        });

        $formations = $formations->toArray();
        $formations = array_map(function($formation) {
             return $formation['id'];
        }, $formations);

        $formations = array_unique($formations);

        return $formations;
    }
}
