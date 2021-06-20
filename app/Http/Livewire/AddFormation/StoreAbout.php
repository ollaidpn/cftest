<?php

namespace App\Http\Livewire\AddFormation;

use App\Models\Formation;
use App\Models\Goal;
use App\Models\Requirement;
use App\Models\TargetedSkill;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class StoreAbout extends Component
{
    public $requirement, $goal, $practical_informations, $targetedSkill;

    public function mount() {
        $this->requirement = [
            'title' => '',
            'formation_id' => session('actual_formation')->id ?? null,
        ];

        $this->goal = [
            'title' => '',
            'formation_id' => session('actual_formation')->id ?? null,
        ];

        $this->targetedSkill = [
            'title' => '',
            'formation_id' => session('actual_formation')->id ?? null,
        ];

        session()->forget('about_success');
    }

    public function updated() {
        $this->goal['formation_id'] = session('actual_formation')->id ?? null;
        $this->requirement['formation_id'] = session('actual_formation')->id ?? null;
        $this->targetedSkill['formation_id'] = session('actual_formation')->id ?? null;
    }

    public function storePracticalInformations()
    {
        $formation = Formation::find(session('actual_formation')->id);
        if ($formation) {
            $formation->practical_informations = $this->practical_informations;
            $formation->update();
        } else {
            abort(404);
        }
    }

    public function storeRequirement()
    {
        $validator = Validator::make($this->requirement, [
            'title' => 'required|string|max:255',
            'formation_id' => 'required|numeric',
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
            session()->put('about_success', false);
            return null;
        }

        $requirement = new Requirement();
        $requirement->title = $this->requirement['title'];
        $requirement->formation_id = $this->requirement['formation_id'];

        if ($requirement->save()) {
            session()->put('about_success', true);
            $this->reset("requirement");
        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }
    }

    public function storeGoal()
    {
        $validator = Validator::make($this->goal, [
            'title' => 'required|string|max:255',
            'formation_id' => 'required|numeric',
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
            session()->put('about_success', false);
            return null;
        }

        $goal = new Goal();
        $goal->title = $this->goal['title'];
        $goal->formation_id = $this->goal['formation_id'];

        if ($goal->save()) {
            session()->put('about_success', true);
            $this->reset("goal");
        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }
    }

    public function storeTargetedSkill()
    {
        $validator = Validator::make($this->targetedSkill, [
            'title' => 'required|string|max:255',
            'formation_id' => 'required|numeric',
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
            session()->put('about_success', false);
            return null;
        }

        $targetedSkill = new TargetedSkill();
        $targetedSkill->title = $this->targetedSkill['title'];
        $targetedSkill->formation_id = $this->targetedSkill['formation_id'];

        if ($targetedSkill->save()) {
            session()->put('about_success', true);
            $this->reset("targetedSkill");
        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }
    }

    public function deleteRequirement($id)
    {
        $requirement = Requirement::find($id);
        if ($requirement) {
            $requirement->delete();
        }
    }

    public function deleteGoal($id)
    {
        $goal = Goal::find($id);
        if ($goal) {
            $goal->delete();
        }
    }

    public function deleteTargetedSkill($id)
    {
        $targetedSkill = TargetedSkill::find($id);
        if ($targetedSkill) {
            $targetedSkill->delete();
        }
    }

    public function selectTab($tab)
    {
        $this->emit('selectTab', $tab);
    }

    public function render()
    {
        return view('livewire.formation.store-about', [
            'goals' => Goal::where('formation_id', session('actual_formation')->id ?? 0)->get(),
            'requirements' => Requirement::where('formation_id', session('actual_formation')->id ?? 0)->get(),
            'targetedSkills' => TargetedSkill::where('formation_id', session('actual_formation')->id ?? 0)->get(),
        ]);
    }
}
