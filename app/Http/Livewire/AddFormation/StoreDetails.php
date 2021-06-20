<?php

namespace App\Http\Livewire\AddFormation;
use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\Models\Categorie;
use App\Models\Formation;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Support\Str;
use League\CommonMark\Inline\Element\Strong;
use Livewire\WithFileUploads;

class StoreDetails extends Component
{
    use WithFileUploads;

    public $formation = [
        'title' => '',
        'description' => '',
        'categories' => [],
        'nb_hours' => 0,
        'teacher' => '',

        // 'organization_id' => 0,
        'teams' => [],
        'image' => null,
        'video' => null,
        'type' => 'public',
        'price' => 0,
    ];
    public $actual_formation, $teams = [];

    public function mount()
    {
        $this->formation['teacher'] = User::whereHas('role', function($q){
                $q->where('slug', 'teacher');
            })->get()->first();
        $this->emit('scrollTop');
        session()->forget('details_success');
    }

    public function hydrate()
    {
        $this->resetValidation();
        $this->emit('reloadSelect2');
    }

    public function loadTeams($id)
    {
        if($id!=='Aucune'){
        $this->emit('reloadSelect2');
        $organization = Organization::where("id",$id)->with('teams')->get()->first();
        if ($organization) {
            $organization->teams ? $this->teams = $organization->teams : '';
        } else {
            abort(404);
        }
    }
    }

    public function storeDetails()
    {
        $validator = Validator::make($this->formation, [
            'title' => 'required|string|max:255|unique:formations,title',
            'description' => 'required|string',
            'categories' => 'required',
            // 'organization_id' => 'numeric|required',
            'nb_hours' => 'required|numeric',
            'teacher' => 'required|string',
            'price' => 'numeric|required',
            'type' => 'required|string|max:10',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'video' => 'required',
        ]);
        set_time_limit(3000);

        if ($validator->fails()) {
            foreach ($validator->errors()->toArray() as $key => $value) {
                if (is_array($value)) {
                    for ($i=0; $i < sizeof($value); $i++) {
                        $this->addError($key, $value[$i]);
                    }
                } else {
                    $this->addError($key, $value);
                }
            }

            $this->emit('scrollTop');
            session()->put('details_success', false);
            return null;
        }


        $formation = new Formation();
        // $formation->organization_id =  $request->input('organization');

        $formation->title = $this->formation['title'];
        $formation->presentation_text = $this->formation['description'];
        $formation->nb_hours = $this->formation['nb_hours'];
        $formation->type = $this->formation['type'];
        // $formation->organization_id = $this->formation['organization'];

        $formation->timeline = 0;
        $formation->price = $this->formation['price'];
        $formation->slug = Str::slug($this->formation['title']);

        $image_name = Str::uuid().".".$this->formation['image']->extension();
        $formation->image = $this->formation['image']->storeAs('uploads/formation'."/". date('Y')."/". date('F'), $image_name);

        $id_video = uploadVideoToVimeo($this->formation['video']->path(), $this->formation['title'], $this->formation['description']);
        $folder = createVimeoFolder($this->formation['title']);
        moveVideoToFolder($folder->json()['uri'], $id_video);
        $formation->presentation_video = $id_video;
        $formation->uri_folder = $folder->json()['uri'];

        if ($formation->save()) {
            $formation->users()->attach($this->formation['teacher']);
            $formation->teams()->attach($this->formation['teams']);
            $formation->categories()->attach($this->formation['categories']);
            session()->put('actual_formation', $formation);
            $IdFormation =  DB::table('formations')->orderBy('created_at', 'desc')->first();
            $urla = route(Auth::user()->role->slug.'.dashboard');
            $repo = "/modifier-cours/";
            $IdFormation = $IdFormation->id;
            $urla = "$urla$repo$IdFormation";
            redirect($urla);
            // redirect(url('/admin/modifier-cours/'.$IdFormation->id));
            $this->emit('scrollTop');
            $this->emit('selectTab', 'about');
            session()->flash('success',  'Cours '.$formation->title.' ajouté avec succès, Veuillez remplir les parties  A-propos, Modules, puis Quizz  pour terminer.');
            session()->put('details_success', true);

        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }

    }

    public function render()
    {

        if(Auth::user()->role->slug==='admin'){
            $teachers = User::whereHas('role', function($q){
                $q->where('slug', 'teacher');
            })->get();
        }else{
            $teachers = [Auth::user()];
        }
        return view('livewire.formation.store-details', [
            'categories' => json_encode(Categorie::orderBy('title')->get()->toArray()),
            'teachers' => $teachers,
            'organizations' => Organization::orderBy('name')->get(),

        ]);
    }
}
