<?php

namespace App\Http\Livewire;

use App\Models\Formation;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;

class Answers extends Component

{
    use WithPagination;

    public $perPage = 5;
    public $formation, $module_id, $query, $answer,$question, $action="create", $button, $is_updating;

    public function AllQuestion()
    {
        $columns = Schema::getColumnListing('quiz_answers');
        $quizQestionQuery = QuizAnswer::query();
        foreach ($columns as $column) {
            $quizQestionQuery->orWhere($column, 'LIKE', '%'.$this->query.'%');
        }

        $result = $quizQestionQuery->paginate($this->perPage);

        // dd($result);
        return $result;
    }

    public function render()
    {
        return view('livewire.quizz.answers', [
            'quiz_answers' => $this->AllQuestion(),
            'formations' => Formation::all(),
            'modules' => Module::all(),
            'queezes' => Quiz::all(),

        ]);
    }
    // public function render()
    // {
    //     return view('livewire.quizz.quizz'),
    //     [
    //         'quiz_answers' => $this->AllQuestion(),
    //         'formations' => Formation::all(),
    //         'modules' => Module::all(),
    //         'queezes' => Quiz::all(),

    //     ];
    // }

    public function create()
    {
        $this->validate([
            'answer' => 'required|string',
            'formation' => 'required|numeric',
            'module_id' => 'required|numeric'

        ]);

        $selectedModule = Module::find($this->module_id);

        if ($selectedModule) {
            $answers = new Quiz();
            $answers->title = $selectedModule->title;
            $answers->module_id = $selectedModule->id;
            $answers->save();

            $quiz_answers = new QuizAnswer();
            $quiz_answers->answer = $this->answer;
            $quiz_answers->quiz_question_id = $quiz_answers->id;

            if ($quiz_answers->save()) {
                session()->flash('success', "La réponse; " . $this->answer . " a été ajoutée avec succès.");
                $this->reset();
            } else {
                session()->flash('error', 'Une erreur est survenu lors de la création de la filière.');
            }
        }
            // $quiz_question->save();

        }


}
