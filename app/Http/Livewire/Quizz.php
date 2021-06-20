<?php

namespace App\Http\Livewire;

use App\Models\Formation;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Quizz extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $formation, $module_id, $query, $question, $action="create", $button,$selectId,$is_updating;

    public function AllQuestion()
    {
        $columns = Schema::getColumnListing('quiz_questions');
        $quizQestionQuery = QuizQuestion::query();
        foreach ($columns as $column) {
            $quizQestionQuery->orWhere($column, 'LIKE', '%'.$this->query.'%');
        }

        $result = $quizQestionQuery->paginate($this->perPage);

        // dd($result);
        return $result;
    }


    public function render()
    {
        return view('livewire.quizz.quizz', [
            'quiz_questions' => $this->AllQuestion(),
            'formations' => Formation::all(),
            'modules' => Module::all(),
            'queezes' => Quiz::all(),

        ]);
    }

    public function edit($id)
    {
        $quiz_question=QuizQuestion::find($id);
        if ($quiz_question) {
            $this->question=$quiz_question->question;
            $this->formation=$quiz_question->quiz->module->formation->id;
            $this->module_id=$quiz_question->quiz->module->id;

            $this->action="update($id)";
        }
    }


    // create
    public function update($id)
    {
        $this->validate([
            'question' => 'required|string',
            'formation' => 'required|numeric',
            'module_id' => 'required|numeric'

        ]);

        $quiz_question = QuizQuestion::find($id);

        if ($quiz_question) {

            $module = Module::find($this->module_id);
            if ($module) {
                $quizze = Quiz::where('title', $module->title)->get()->first();
                if (!$quizze) {
                    $quizze = new Quiz();
                    $quizze->title = $module->title;
                    $quizze->module_id = $module->id;
                    $quizze->save();
                }
            }

            $quiz_question->question = $this->question;
            $quiz_question->quizze_id = $quizze->id;

            if ($quiz_question->update()) {
                session()->flash('success', "La question; " . $this->question . " a été modifiée avec succès.");
                $this->reset();
            } else {
                session()->flash('error', 'Une erreur est survenu lors de la création.');
            }
        }
            // $quiz_question->save();

        }
        public function delete($id)
        {
            $quiz_question = QuizQuestion::find($id);
            if ($quiz_question) {
                $quiz_question->delete();
                session()-> flash('success',"quizz suppprimer avec succes ");
            }
        }
        public function selectId($id)
        {
            $this-> selectedId=$id;
        }


    public function create()
    {
        $this->validate([
            'question' => 'required|string',
            'formation' => 'required|numeric',
            'module_id' => 'required|numeric'

        ]);

        $selectedModule = Module::find($this->module_id);

        if ($selectedModule) {
            $quizze = new Quiz();
            $quizze->title = $selectedModule->title;
            $quizze->module_id = $selectedModule->id;
            $quizze->save();

            $quiz_question = new QuizQuestion();
            $quiz_question->question = $this->question;
            $quiz_question->quizze_id = $quizze->id;

            if ($quiz_question->save()) {
                session()->flash('success', "La question; " . $this->question . " a été ajoutée avec succès.");
                $this->reset();
            } else {
                session()->flash('error', 'Une erreur est survenu lors de la création de la filière.');
            }
        }
            // $quiz_question->save();

        }








}
