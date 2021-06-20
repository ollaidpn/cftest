<?php

namespace App\Http\Livewire\AddFormation;

use App\Models\Module;
use App\Models\Section;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class StoreModules extends Component
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
    public $actual_formation, $module;

    public function mount()
    {
        $this->emit('scrollTop');
        session()->forget('module_success');
    }

    public function selectTab($tab)
    {
        $this->emit('selectTab', $tab);
    }

    public function storeModules()
    {
        $validator = Validator::make($this->section, [
            'module_title' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video' => 'required|file',
            'reference' => 'file|mimes:pdf,pptx,docx|max:5120|nullable',
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
                        ->where('formation_id', session('actual_formation')->id)
                        ->get()
                        ->first();

        if (!$module) {
            $module = new Module();
            $module->title = $this->section['module_title'];
            $module->formation_id = session('actual_formation')->id;
            $module->save();
        }

        $this->module = $module;

        $section = new Section();
        $section->title = $this->section['title'];
        $section->presentation_text = $this->section['description'];
        $section->other = $this->section['other'];
        $section->slug = Str::slug($this->section['title']);
        $section->module_id = $this->module->id;

        if ($this->section['reference']) {
            $reference_name = Str::uuid().".".$this->section['reference']->extension();
            $section->reference = $this->section['reference']->storeAs('uploads/reference'."/". date('Y')."/". date('F'), $reference_name);
        }

        $id_video = uploadVideoToVimeo($this->section['video']->path(), $this->section['title'], $this->section['description']);
        moveVideoToFolder(session('actual_formation')->uri_folder, $id_video);
        $section->video = $id_video;

        if ($section->save()) {
            session()->put('module_success', true);
            $this->emit('scrollTop');
            $module_title = $this->section['module_title'];
            $this->reset('section');
            $this->section['module_title'] = $module_title;
            $this->emit('reset');

        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }

    }

    public function render()
    {
        return view('livewire.formation.store-modules', [
            'modules' => Module::where('formation_id', session('actual_formation')->id ?? 0)
                                ->get(),
            'count_modules' => Module::where('formation_id', session('actual_formation')->id ?? 0)
                                ->get()
                                ->count(),
        ]);
    }
}
