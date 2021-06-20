<?php

namespace App\Http\Controllers;

use App\Mail\AnswerMail;
use App\Models\Formation;
use App\Models\FormationUser;
use App\Models\MsgVisitor;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function dashboard () {
        $page_title = "Tableau de bord";

        // Count Users
        $count_users = User::count();
        $count_today_new_user = User::whereDate('created_at', Carbon::today())->get()->count();

        // Count Students
        $count_students = User::whereHas('role', function($role) {
            $role->where('slug', 'student');
        })->get()->count();

        $count_today_new_students = User::whereHas('role', function($role) {
            $role->where('slug', 'student');
        })->whereDate('created_at', Carbon::today())->get()->count();

        // Count Teachers
        $count_teachers = User::whereHas('role', function($role) {
            $role->where('slug', 'teacher');
        })->get()->count();

        $count_today_new_teachers = User::whereHas('role', function($role) {
            $role->where('slug', 'student');
        })->whereDate('created_at', Carbon::today())->get()->count();

        // Count Educational Admins
        $count_educational_admins = User::whereHas('role', function($role) {
            $role->where('slug', 'educational-admin');
        })->get()->count();

        $count_today_new_educational_admins = User::whereHas('role', function($role) {
            $role->where('slug', 'educational-admin');
        })->whereDate('created_at', Carbon::today())->get()->count();

        // Count Formations
        $count_formations = Formation::count();
        $count_today_new_formations = Formation::whereDate('created_at', Carbon::today())->get()->count();

        // Count Public Formations
        $count_public_formations = Formation::where('type', 'public')->get()->count();
        $count_today_new_public_formations = Formation::whereDate('created_at', Carbon::today())->where('type', 'public')->get()->count();

        // Count Private Formations
        $count_private_formations = Formation::where('type', 'private')->get()->count();
        $count_today_new_private_formations = Formation::whereDate('created_at', Carbon::today())->where('type', 'private')->get()->count();

        // Last Four Messages
        $last_four_messages = MsgVisitor::orderByDesc('id')->take(4)->get();

        // Last Five Testimonials
        $last_five_testimonials = Testimonial::orderByDesc('id')->take(5)->get();

        // Almost Finished Formation
        $six_almost_finished_formations = FormationUser::where('status', 'in process')
                                                        ->orderByDesc('id')->take(6)->get();
        $six_almost_finished_formations = $six_almost_finished_formations->map(function($value) {
            return collect([
                    'user' => User::find($value->user_id),
                    'formation' => Formation::find($value->formation_id),
                    'process' => $value->process
                ]);
        });

        // Last applications
        $last_applications = FormationUser::where('status', 'in process')->orderByDesc('id')->take(8)->get();
        setlocale(LC_TIME, "fr_FR");
        $last_applications = $last_applications->map(function($value) {
            return collect([
                    'user' => User::find($value->user_id),
                    'formation' => Formation::find($value->formation_id),
                    'created_at' => strftime("%e %B %Y", strtotime($value->created_at))
                ]);
        });
// $test = route(Auth::user()->role->slug.'.dashboard');
// $test1 = "/modifier-cours/2";
// $test = "$test$test1";
// dd($test);
        // Last 10 Formations
        $last_ten_formations = Formation::orderByDesc('id')->take(10)->get();

        return view(Auth::user()->role->slug.'.index', compact('page_title', 'count_users', 'count_today_new_user', 'count_students', 'count_today_new_students',
                                                                'count_today_new_teachers', 'count_teachers', 'count_today_new_educational_admins', 'count_educational_admins',
                                                                'count_formations', 'count_today_new_formations', 'count_public_formations', 'count_today_new_public_formations',
                                                                'count_private_formations', 'count_today_new_private_formations', 'last_four_messages', 'last_five_testimonials',
                                                                'last_applications', 'last_ten_formations', 'six_almost_finished_formations'
                                                            ));
    }

    public function sendEmail(Request $request) {
        $request->validate([
            'email' => 'email|required',
            'body' => 'string|required',
            ]);

        Mail::to($request->email)->send(new AnswerMail($request));
        session()->flash('success', 'Réponse envoyée avec succès');
        return back();
    }
}
