<?php

namespace App\Http\Livewire\UpdateFormation;

use App\Models\Module;
use App\Models\Section;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateModules extends Component
{
    use WithFileUploads;

    public $section = [
        'title' => '',
        'description' => '',
        'video' => null,
        'reference' => null,
        'other' => '',
        'module_title' => ''
    ];
    public $actual_formation, $module, $selectedSection = null, $action = "storeNewModuleWithSection";

    public function mount($formation)
    {
        $this->actual_formation = $formation;
        $this->emit('scrollTop');
        session()->forget('module_success');
        // dd(getVimeoVideo('493066234')->json());
    }

    public function selectTab($tab)
    {
        $this->emit('selectTab', $tab);
    }

    public function selectSection($id)
    {
        $section = Section::find($id);
        $this->selectedSection = $section;
        if (!$section) {
            abort(404);
        }

        // dd($section);

        $this->section = [
            'title' => $section->title ?? '',
            'description' => $section->presentation_text ?? '',
            'video' => null,
            'reference' => null,
            'other' => $section->other ?? '',
            'module_title' => $section->module->title ?? '',
        ];
        // dd($this->section);
        $this->emit('setVideo', asset('storage/'.$section->video));
        $this->emit('setReference', asset('storage/'.$section->reference));
        $this->action = "updateSectionAndModule";
    }

    public function deleteSection($id)
    {
        $section = Section::find($id);
        if ($section) {
            $section->delete();
        }
    }

    public function deleteModule($id)
    {
        $module = Module::find($id);
        if ($module) {
            $module->delete();
        }
    }

    public function resetAll()
    {
        $this->reset('section', 'selectedSection', 'action');
        $this->emit('reset');
    }

    public function addSection($id)
    {
        $module = Module::find($id);
        if (!$module) {
            abort(404);
        }

        $this->section['module_title'] = $module->title;
        $this->action = "storeNewSection";
    }

    public function storeNewSection()
    {
        $validator = Validator::make($this->section, [
            'module_title' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video' => 'required',
            'reference' => 'nullable|array',
            'other' => 'nullable|string|max:255',
        ]);

        if($validator->fails()) {
            // dd($validator->errors());
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
            session()->put('module_success', false);
            return null;
        }

        $module = Module::where('title', $this->section['module_title'])
            ->where('formation_id', $this->actual_formation->id)
            ->get()
            ->first();

        if (!$module) {
            $this->addError('module_title', 'Aucun module portant ce nom !');
            return null;
        }

        $section = Section::where('title', $this->section['title'])
                ->where('module_id', $module->id)
                ->get()
                ->first();

        if ($section) {
            $this->addError('title', 'Cette section existe déjà !');
            return null;

        } else {

            $section = new Section();
            $section->title = $this->section['title'];
            $section->presentation_text = $this->section['description'];
            $section->other = $this->section['other'];
            $section->slug = Str::slug($this->section['title']);
            $section->module_id = $module->id;

            if ($this->section['reference']) {
                $namefile = [];

                foreach($this->section['reference'] as $file){
                    $reference_name = Str::uuid().".".$file->extension();
                    array_push($namefile ,$file->storeAs('uploads/reference'."/". date('Y')."/". date('F'), $reference_name)  );
                }
                $section->reference = json_encode($namefile);
            }

            if ($this->section['video']) {

                $id_video = uploadVideoToVimeo($this->section['video']->path(), $this->section['title'], $this->section['description']);
                moveVideoToFolder($this->actual_formation->uri_folder, $id_video);
                $section->video = $id_video;
            }

            if ($section->save()) {
                session()->put('module_success', true);
                $this->emit('scrollTop');
                $this->reset('section', 'selectedSection', 'action');
                $this->emit('reset');

            } else {
                session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
            }
        }
    }

    public function updateSectionAndModule()
    {
        $validator = Validator::make($this->section, [
            'module_title' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video' => !$this->section['video'] ? 'nullable' : 'required|file|max:1024000',
            'reference' => 'nullable|array',
            'other' => 'nullable|string|max:255',
        ]);

        if($validator->fails()) {
            // dd($validator->errors());
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
            session()->put('module_success', false);
            return null;
        }

        $module = $this->selectedSection->module;

        if ($module->title !== $this->section['module_title']) {

            $module->title = $this->section['module_title'];
            $module->formation_id = $this->actual_formation->id;
            $module->update();

        }
        // $this->module = $module;

        $section = $this->selectedSection;
        $section->title = $this->section['title'];
        $section->presentation_text = $this->section['description'];
        $section->other = $this->section['other'];
        $section->slug = Str::slug($this->section['title']);
        $section->module_id = $module->id;

        // dd($this->section['reference']);
        if ($this->section['reference']) {
            File::delete(asset("storage/".$section->reference));
            $namefile = [];

            foreach($this->section['reference'] as $file => $n){
                // Str::uuid()
                $reference_name = $this->section['title'].".".$file->extension();
                array_push($namefile ,$file->storeAs('uploads/reference'."/". date('Y')."/". date('F'), $reference_name)  );
            }
            $section->reference = json_encode($namefile);
        }

        if ($this->section['video']) {

            $reponse = getVimeoVideo($this->selectedSection->video)->json();
            if ($reponse['status'])
                deleteVimeoVideo($this->selectedSection->video);

            $id_video = uploadVideoToVimeo($this->section['video']->path(), $this->section['title'], $this->section['description']);
            moveVideoToFolder($this->actual_formation->uri_folder, $id_video);
            $section->video = $id_video;
        }

        if ($section->update()) {
            $this->emit('scrollTop');
            $this->reset('section', 'selectedSection', 'action');
            $this->emit('reset');
        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }

    }

    public function storeNewModuleWithSection()
    {
        $validator = Validator::make($this->section, [
            'module_title' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video' => 'required',
            'reference' => 'nullable|array',
            'other' => 'nullable|string|max:255',
        ]);

        if($validator->fails()) {
            // dd($validator->errors());
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
            session()->put('module_success', false);
            return null;
        }

        $module = Module::where('title', $this->section['module_title'])
            ->where('formation_id', $this->actual_formation->id)
            ->get()
            ->first();

        if (!$module) {
            $module = new Module();
            $module->title = $this->section['module_title'];
            $module->formation_id = $this->actual_formation->id;
            $module->save();

        } else {
            $this->addError('module_title', 'Ce module existe déjà !');
            return null;
        }

        $section = Section::where('title', $this->section['title'])
                ->where('module_id', $module->id)
                ->get()
                ->first();

        if ($section) {
            $this->addError('title', 'Cette section existe déjà !');
            return null;

        } else {

            $section = new Section();
            $section->title = $this->section['title'];
            $section->presentation_text = $this->section['description'];
            $section->other = $this->section['other'];
            $section->slug = Str::slug($this->section['title']);
            $section->module_id = $module->id;

            if ($this->section['reference']) { $namefile = [];

                foreach($this->section['reference'] as $file){
                    $reference_name = Str::uuid().".".$file->extension();
                    array_push($namefile ,$file->storeAs('uploads/reference'."/". date('Y')."/". date('F'), $reference_name)  );
                }
                $section->reference = json_encode($namefile);
            }

            if ($this->section['video']) {

                $id_video = uploadVideoToVimeo($this->section['video']->path(), $this->section['title'], $this->section['description']);
                moveVideoToFolder($this->actual_formation->uri_folder, $id_video);
                $section->video = $id_video;
            }

            if ($section->save()) {
                session()->put('module_success', true);
                $this->emit('scrollTop');
                $this->reset('section', 'selectedSection', 'action');
                $this->emit('reset');

            } else {
                session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
            }
        }


    }

    public function render()
    {
        return view('livewire.formation.update-formation.update-modules', [
            'modules' => Module::where('formation_id', $this->actual_formation->id ?? 0)
                                ->get(),
            'count_modules' => Module::where('formation_id',  $this->actual_formation->id ?? 0)
                                ->get()
                                ->count(),
        ]);
    }
}
