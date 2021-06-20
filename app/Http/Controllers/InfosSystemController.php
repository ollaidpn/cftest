<?php

namespace App\Http\Controllers;
use App\Models\InfosSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class InfosSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Informations du Système";
        $infosSystems = InfosSystem::find(1);
        return view(Auth::user()->role->slug.'.settings.index', compact('infosSystems', 'page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $page_title = "Informations du Système";

        $this->validate($request, [
            'system_name'=>'required|string|max:255',
            'fixe'=>'nullable|max:20|string',
            'system_email'=>'nullable|email',
            'address'=>'nullable|string|max:255',
            'mobile'=>'nullable|max:20|string',
            'logo' => $request->logo ? 'required' : 'nullable' .'|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'favicon' => $request->favicon ? 'required' : 'nullable' .'|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'img_slider' => $request->img_slider ? 'required' : 'nullable' .'|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'img_header' => $request->img_header ? 'required' : 'nullable' .'|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $infosSystems = InfosSystem::find(1);

        if (!$infosSystems)
            $infosSystems = new InfosSystem();

        $infosSystems->system_name=$request->input('system_name');
        $infosSystems->system_email=$request->input('system_email');
        $infosSystems->address=$request->input('address');
        $infosSystems->fixe=$request->input('fixe');
        $infosSystems->mobile=$request->input('mobile');

        $infosSystems->facebook=$request->input('facebook');
        $infosSystems->insta=$request->input('insta');
        $infosSystems->twitter=$request->input('twitter');
        $infosSystems->linkedin=$request->input('linkedin');

        if ($request->hasFile('logo')) {

            $infosSystems->logo ? File::delete(public_path($infosSystems->logo)) : '';
            $logo_name = time().'.'.$request->logo->getClientOriginalExtension();
            $path_name = 'uploads/settings/logo'."/". date('Y')."/". date('F'). '/';
            if ($request->logo->move("storage/".$path_name, $logo_name)) {
                $infosSystems->logo = $path_name.$logo_name;
            }

        }

        if ($request->hasFile('favicon')) {

            $infosSystems->favicon ? File::delete(public_path($infosSystems->favicon)) : '';
            $favicon_name = time().'.'.$request->favicon->getClientOriginalExtension();
            $path_name = 'uploads/settings/favicon'."/". date('Y')."/". date('F'). '/';
            if ($request->favicon->move("storage/".$path_name, $favicon_name)) {
                $infosSystems->favicon = $path_name.$favicon_name;
            }

        }

        if ($request->hasFile('img_slider')) {

            $infosSystems->img_slider ? File::delete(public_path($infosSystems->img_slider)) : '';
            $img_slider_name = time().'.'.$request->img_slider->getClientOriginalExtension();
            $path_name = 'uploads/settings/img_slider'."/". date('Y')."/". date('F'). '/';
            if ($request->img_slider->move("storage/".$path_name, $img_slider_name)) {
                $infosSystems->img_slider = $path_name.$img_slider_name;
            }

        }

        if ($request->hasFile('img_header')) {

            $infosSystems->img_header ? File::delete(public_path($infosSystems->img_header)) : '';
            $img_header_name = time().'.'.$request->img_header->getClientOriginalExtension();
            $path_name = 'uploads/settings/img_header'."/". date('Y')."/". date('F'). '/';
            if ($request->img_header->move("storage/".$path_name, $img_header_name)) {
                $infosSystems->img_header = $path_name.$img_header_name;
            }

        }

        if (InfosSystem::find(1)) {

            if ($infosSystems->update()) {
                session()->flash('success', 'Information mise à jour avec succès !');
            } else {
                session()->flash('error', 'Une erreur est survenu lors de la mise à jour !');
            }
        } else {

            if ($infosSystems->save()) {
                session()->flash('success', 'Information mise à jour avec succès !');
            } else {
                session()->flash('error', 'Une erreur est survenu lors de la sauvegarde !');
            }
        }

        return view(Auth::user()->role->slug.'.settings.index', compact('infosSystems', 'page_title'));
    }
}
