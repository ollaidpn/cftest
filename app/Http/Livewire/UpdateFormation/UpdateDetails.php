<?php

namespace App\Http\Livewire\UpdateFormation;

use App\Models\Categorie;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class UpdateDetails extends Component
{
    use WithFileUploads;

    public $formation, $actual_formation, $teams = [], $teams_id = [];

    public function mount($formation)
    {
        $this->formation = [
                        'title' => $formation->title ?? '',
                        'description' => $formation->presentation_text ?? '',
                        'categories' => $formation->categories ?? [],
                        'nb_hours' => $formation->nb_hours ?? '',
                        'teacher' => $formation->users[0]->id ?? null,
                        'teams' => $formation->teams ?? null,
                        'image' => null,
                        'video' => null,
                        'type' => $formation->type ?? '',
                        'price' => $formation->price,
                        'show_stats' => $formation->show_stats,
                        'organization' => count($formation->teams) > 0 ? $formation->teams->first()->organization->id : ''
                    ];
        $this->actual_formation = $formation;
        $this->loadTeams($this->formation['organization']);

        $this->emit('scrollTop');
        session()->forget('details_success');
    }

    public function hydrate()
    {
        $this->resetValidation();
    }

    public function loadTeams($id)
    {
        $organization = Organization::where("id",$id)->with('teams')->get()->first();
        if ($organization) {
            count($organization->teams) > 0 ? $this->teams = $organization->teams : $this->teams = [];
        }
    }

    public function updateDetails()
    {
        $validator = Validator::make($this->formation, [
            'title' => 'required|string|max:255|unique:formations,title,'.$this->actual_formation->id,
            'description' => 'required|string',
            'categories' => 'required',
            'nb_hours' => 'required|numeric',
            'teacher' => 'required|numeric',
            'type' => 'required|string|max:10',
            'price' => 'required|numeric',
            'image' => !$this->formation['image'] ? 'nullable' : 'required'.'|image|mimes:jpg,png,jpeg|max:2048',
            'video' => !$this->formation['video'] ? 'nullable' : 'required|file',
        ]);

        if($validator->fails()) {
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

        $formation = $this->actual_formation;
        $formation->title = $this->formation['title'];
        $formation->presentation_text = $this->formation['description'];
        $formation->nb_hours = $this->formation['nb_hours'];
        $formation->type = $this->formation['type'];
        $formation->timeline = 0;
        $formation->price = $this->formation['price'];
        $formation->show_stats = $this->formation['show_stats'];
        $formation->slug = Str::slug($this->formation['title']);

        if ($this->formation['image']) {

            $image_name = Str::uuid().".".$this->formation['image']->extension();
            $formation->image = $this->formation['image']->storeAs('uploads/formation'."/". date('Y')."/". date('F'), $image_name);

            File::delete(asset("storage/".$this->actual_formation->image));
        }

        if ($this->formation['video']) {

            $reponse = getVimeoVideo($this->actual_formation->presentation_video)->json();
            if ($reponse['status'])
                deleteVimeoVideo($this->actual_formation->presentation_video);

            $id_video = uploadVideoToVimeo($this->formation['video']->path(), $this->formation['title'], $this->formation['description']);
            moveVideoToFolder($this->actual_formation->uri_folder, $id_video);
            $formation->presentation_video = $id_video;
        }

        $categories = [];
        if (is_array($this->formation['categories'])) {

            foreach ($this->formation['categories'] as $categorie) {
                    array_push($categories, intval($categorie));
            }

        } else {

            $categories = explode(',', $this->formation['categories']);
            $categories = array_map(function($value) {
                    return intval($value);
                }, $categories);
        }

        if ($formation->update()) {
            $formation->users()->sync($this->formation['teacher']);

            if (count($this->formation['teams']) > 0 && $this->formation['teams'][0] && is_array($this->formation['teams'][0])) {

                $teams = array_map(function($value) {
                    return $value['id'];
                }, $this->formation['teams']);

                $formation->teams()->sync($teams);
            } else {
                $formation->teams()->sync($this->formation['teams']);
            }

            $formation->categories()->sync($categories);
            session()->flash('success', 'Enregistrement des details de la formation réussi, passez au modules et sections.');
            $this->emit('scrollTop');
            $this->emit('selectTab', 'about');
            session()->put('details_success', true);
        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }

    }

    public function render()
    {
        $this->teams_id = [];
        foreach ($this->formation['teams'] as $team) {
            array_push($this->teams_id, $team->id ?? $team);
        }
        $this->emit('reinitializeTeams');

        if(Auth::user()->role->slug==='admin'){
            $teachers = User::whereHas('role', function($q){
                $q->where('slug', 'teacher');
            })->get();
        }else{
            $teachers = [Auth::user()];
        }
        return view('livewire.formation.update-formation.update-details', [
            'categories' => json_encode(Categorie::orderBy('title')->get()->toArray()),
            'teachers' => $teachers,
            'organizations' => Organization::orderBy('name')->get(),
        ]);
    }
}
