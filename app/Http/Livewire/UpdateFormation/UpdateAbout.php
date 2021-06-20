<?php

namespace App\Http\Livewire\UpdateFormation;

use App\Models\Goal;
use App\Models\Requirement;
use App\Models\TargetedSkill;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdateAbout extends Component
{
    public $requirement, $targetedSkill, $goal, $formation, $selectedRequirement = 0, $selectedGoal = 0, $goalAction = "storeGoal", $requirementAction = "storeRequirement";
    public $targetedSkillAction = "storeTargetedSkill", $practical_informations;
    public function mount($formation) {
        $this->formation = $formation;
        $this->practical_informations = $formation->practical_informations;
        $this->requirement = [
            'title_requirement' => '',
            'formation_id' => $this->formation->id ?? null,
        ];

        $this->goal = [
            'title_goal' => '',
            'formation_id' => $this->formation->id ?? null,
        ];

        $this->targetedSkill = [
            'title_targetedSkill' => '',
            'formation_id' => $this->formation->id ?? null,
        ];

        session()->forget('about_success');
    }

    public function updatePracticalInformations()
    {
        if ($this->formation) {
            $this->formation->practical_informations = $this->practical_informations;
            $this->formation->update();
        } else {
            abort(404);
        }
    }

    public function updated() {
        $this->goal['formation_id'] = $this->formation->id ?? null;
        $this->requirement['formation_id'] = $this->formation->id ?? null;
    }

    public function storeRequirement()
    {
        $validator = Validator::make($this->requirement, [
            'title_requirement' => 'required|string|max:255',
            'formation_id' => 'required|numeric',
        ]);

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
            session()->put('about_success', false);
            return null;
        }

        $requirement = new Requirement();
        $requirement->title = $this->requirement['title_requirement'];
        $requirement->formation_id = $this->requirement['formation_id'];

        if ($requirement->save()) {
            session()->put('about_success', true);
            $this->reset("requirement", 'requirementAction');
        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }
    }

    public function storeGoal()
    {
        $validator = Validator::make($this->goal, [
            'title_goal' => 'required|string|max:255',
            'formation_id' => 'required|numeric',
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
            session()->put('about_success', false);
            return null;
        }

        $goal = new Goal();
        $goal->title = $this->goal['title_goal'];
        $goal->formation_id = $this->goal['formation_id'];

        if ($goal->save()) {
            session()->put('about_success', true);
            $this->reset("goal", 'goalAction');
        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }
    }

    public function editTargetedSkill($id)
    {
        $targetedSkill = TargetedSkill::find($id);
        if (!$targetedSkill) {
            abort(404);
        }
        $this->targetedSkill['title_targetedSkill'] = $targetedSkill->title;
        $this->targetedSkillAction = "updateTargetedSkill($id)";
    }

    public function storeTargetedSkill()
    {
        $validator = Validator::make($this->targetedSkill, [
            'title_targetedSkill' => 'required|string|max:255',
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
        $targetedSkill->title = $this->targetedSkill['title_targetedSkill'];
        $targetedSkill->formation_id = $this->targetedSkill['formation_id'];

        if ($targetedSkill->save()) {
            session()->put('about_success', true);
            $this->reset("targetedSkill");
        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }
    }

    public function updateTargetedSkill($id)

    {
        $validator = Validator::make($this->targetedSkill, [
            'title_targetedSkill' => 'required|string|max:255',
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

        $targetedSkill = TargetedSkill::find($id);
        if (!$targetedSkill) {
            $this->addError('title_targetedSkill', 'Opération impossible !');
            return null;
        }
        $targetedSkill->title = $this->requirement['title_targetedSkill'];
        $targetedSkill->formation_id = $this->requirement['formation_id'];

        if ($targetedSkill->update()) {
            session()->put('about_success', true);
            $this->reset("targetedSkill", 'targetedSkillAction');
        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }
    }

    public function editRequirement($id)
    {
        $requirement = Requirement::find($id);
        if (!$requirement) {
            abort(404);
        }
        $this->requirement['title_requirement'] = $requirement->title;
        // $this->selectedRequirement = $id;
        $this->requirementAction = "updateRequirement($id)";
    }

    public function editGoal($id)
    {
        $goal = Goal::find($id);
        if (!$goal) {
            abort(404);
        }
        $this->goal['title_goal'] = $goal->title;
        // $this->selectedGoal = $id;
        $this->goalAction = "updateGoal($id)";
    }

    public function updateRequirement($id)
    {
        $validator = Validator::make($this->requirement, [
            'title_requirement' => 'required|string|max:255',
            'formation_id' => 'required|numeric',
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
            session()->put('about_success', false);
            return null;
        }

        $requirement = Requirement::find($id);
        if (!$requirement) {
            $this->addError('title_requirement', 'Opération impossible !');
            return null;
        }
        $requirement->title = $this->requirement['title_requirement'];
        $requirement->formation_id = $this->requirement['formation_id'];

        if ($requirement->update()) {
            session()->put('about_success', true);
            $this->reset("requirement", 'requirementAction');
        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }
    }

    public function updateGoal($id)
    {

        $validator = Validator::make($this->goal, [
            'title_goal' => 'required|string|max:255',
            'formation_id' => 'required|numeric',
        ]);

         if($validator->fails()) {
            // dd($validator->errors());
            // $this->emit('test', $validator->errors());
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

        $goal = Goal::find($id);

        if (!$goal) {
            $this->addError('title_goal', 'Opération impossible !');
            return null;
        }
        $goal->title = $this->goal['title_goal'];
        $goal->formation_id = $this->goal['formation_id'];

        if ($goal->update()) {
            session()->put('about_success', true);
            $this->reset("goal", 'goalAction');
        } else {
            session()->flash('error', 'Erreur lors de l\'enregistrement. Veuillez reessayer !');
        }
    }

    public function deleteRequirement($id)
    {
        $requirement = Requirement::find($id);
        // dd($quizz_answer);
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

    public function selectTab($tab)
    {
        $this->emit('selectTab', $tab);
    }

    public function render()
    {
        return view('livewire.formation.update-formation.update-about', [
            'goals' => Goal::where('formation_id', $this->formation->id ?? 0)->get(),
            'requirements' => Requirement::where('formation_id', $this->formation->id ?? 0)->get(),
            'targetedSkills' => TargetedSkill::where('formation_id', $this->formation->id ?? 0)->get(),
        ]);
    }
}
