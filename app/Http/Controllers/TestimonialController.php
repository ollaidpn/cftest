<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::orderByDesc('id')->get();
        $page_title = "Témoignages";

        return view('admin.testimonial.index', compact('testimonials', 'page_title'));
    }

    public function testimonial(){
        $page_title = "Témoignages";
        return view('student.testimonial.index', compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $id)
    {
        $this->validate($id, [

            'testimonial'=>'required|string',
        ]);
         $temoignage= new Testimonial();

        $temoignage->testimonial=$id->input('testimonial');
        $temoignage->user_id=Auth::user()->id;

        $temoignage->save();
        session()->flash('success', 'Témoignage ajouter avec succes');
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $temoignage = Testimonial::where('id', $id)->with('user')->get()->first();
        if ($temoignage) {
            return response(['testimonial' => $temoignage], 200);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $testimonial = Testimonial::where('id', $id)->with('user')->get()->first();
        if ($testimonial) {
            if ($testimonial->status === "pending") {

                $testimonial->status = 'published';
                $testimonial->update();

            } elseif ($testimonial->status === "published") {

                $testimonial->status = 'pending';
                $testimonial->update();
            }
            return back();
        } else {
            abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Testimonial  $testimonial
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::where('id', $id)->with('user')->get()->first();
        if ($testimonial) {
            $testimonial->delete();
            session()->flash('success', 'Témoignage supprimé avec succès');
            return back();
        } else {
            abort(404);
        }
    }
}
