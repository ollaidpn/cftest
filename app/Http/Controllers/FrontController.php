<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Formation;
use App\Models\InfosSystem;
use App\Models\Enrollement;
use App\Models\Cart;
use App\Models\FormationUser;
use App\Models\MsgVisitor;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function index(){

        $last_formations = Formation::orderByDesc('id')->where('type', 'public')->get()->take(8);
        $most_views_formations = Formation::orderByDesc('views')->where('type', 'public')->get()->take(8);
        $testimonials = Testimonial::where('status', 'published')->get();
        $page_title = "Accueil ";

        return view('front.index',compact('last_formations', 'most_views_formations', 'testimonials', 'page_title'));
}

    public function showCategorie($slug){

        $page_title = str_replace('-', ' ', ucfirst($slug));
        $formations = Formation::where('type', "public")->whereHas('categories', function($category) use($slug) {
            $category->where('slug', $slug);
        })->paginate(12);

        return view('front.showCategorie',compact('formations', 'page_title'));
    }

    public function courses(){
        $formations = Formation::where('type', "public")->orderByDesc('id')->paginate(12);
        $page_title = 'Nos Formations';

        return view('front.courses',compact('formations', 'page_title'));
    }

    public function showCourse($slug){

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

        $categories= Categorie::where('category_parent', null)->get();
        $formation = Formation::where('slug', $slug)->get()->first();
        $Enrollement = FormationUser::where('formation_id', $formation->id)->where('user_id', Auth::user()->id)->get()->first();
        // dd($formation->id);
        // $InCart = Cart::where('formation_id', $formation->id)->where('user_id', Auth::user()->id)->get()->first();

        $page_title = $formation->title;
        if (!$formation)
            abort(404);
        $similar_formations = Formation::whereHas('categories', function($category) use ($formation) {

                            if (count($formation->categories) !== 0) {
                                $category->where('slug', $formation->categories->first()->slug);
                            }

                    })->get()->take(4);

        $count_videos = null;
        if (count($formation->modules) !== 0) {

            foreach ($formation->modules as $module) {

                if (count($module->sections) !== 0) {

                    $count_videos += count($module->sections);
                }
            }
        }

        $count_quizz = null;
        if (count($formation->modules) !== 0) {

            foreach ($formation->modules as $module) {

                if ($module->quiz) {

                    $count_quizz++;
                }
            }
        }
// dd($formation);


        return view('front.coursesView', compact('formation',  'Enrollement', 'similar_formations', 'count_videos', 'count_quizz', 'page_title'));
    }

    public function contact(){
        $page_title = "Contact";
        return view('front.contact', compact('page_title'));
    }

    public function cart(){
        $page_title = "Panier";
        // $InCart =  Cart::where('user_id', Auth::user()->id);
        return view('front.cart', compact('page_title'));
    }

    public function p404(){
        return view('front.p404');
    }

    public function create(){
        return view('contact.message');
    }

    public function message(Request $request)
    {

        $this->validate($request, [

            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'email'=>'required|email',
            'object'=>'required|string',
            'message'=>'required|string',

        ]);

        $Message= new MsgVisitor;

        $Message->first_name=$request->input('first_name');
        $Message->last_name=$request->input('last_name');
        $Message->email=$request->input('email');
        $Message->object=$request->input('object');
        $Message->message=$request->input('message');

        $Message->save();
        return back()->with('success', 'Message envoyé avec succès. Nous vous répondrons dans les plus brefs délais !');
    }

    public function search(Request $request) {

        $page_title = "Résultat ".$request->search;
        $request->validate(['search' => 'string']);
        $formations = Formation::where('title', 'LIKE', '%'.$request->search.'%')->paginate(12);
        return view('front.search', compact('page_title', 'formations'));
    }

    public function construction()
    {
        $page_title = "Page en construction";
        return view("front.construction", compact("page_title"));
    }


}
