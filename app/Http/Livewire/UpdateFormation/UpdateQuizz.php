<?php

namespace App\Http\Livewire\UpdateFormation;

use App\Http\Livewire\Quizz;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdateQuizz extends Component
{
        public $quizz = [
        // 'module_id' => '',
        'question' => '',
        'answer' => null,
        'is_answer_true' => false,
        'module_id' => '',
    ];

    public $actual_question, $actual_selected_module, $update, $formation, $selectedAnswer = null, $action = "storeNewQuiz";

    // public function updatedQuizz()
    // {
    //     dd($this->quizz);
    // }

    public function selectQuestion($id)
    {
        $quizz_question = QuizQuestion::find($id);
        $this->actual_question = $quizz_question;
        if (!$quizz_question) {
            abort(404);
        }

        $this->quizz['question'] = $quizz_question->question;
        $this->quizz['module_id'] = $quizz_question->quiz->module->id;
        $this->action = "updateQuestion($id)";
    }

    public function selectAnswer($id)
    {
        $quizz_answer = QuizAnswer::find($id);
        // $this->actual_question = $quizz_question;
        if (!$quizz_answer) {
            abort(404);
        }

        $this->quizz['answer'] = $quizz_answer->answer;
        $this->quizz['is_answer_true'] = $quizz_answer->is_valid === 1 ? true : false;
        $this->selectedAnswer = $quizz_answer;
        $this->action = "updateAnswer($id)";
    }

    public function storeQuestion($id){

        $validator = Validator::make($this->quizz, [
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
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
            $this->emit('refreshIndex');
            session()->put('quizz_success', false);
            return null;
        }


            $quizz_question = new QuizQuestion();
            $quizz_question->question = $this->quizz['question'];
            $quizz_question->quizze_id = $id;
            $quizz_question->save();


        $quizz_answer = new QuizAnswer();
        $quizz_answer->answer = $this->quizz['answer'];
        $quizz_answer->is_valid = $this->quizz['is_answer_true'] === true ? 1 : 0;
        $quizz_answer->quiz_question_id = $quizz_question->id;
        if ($quizz_answer->save()) {
            $this->emit('scrollTop');
            $module_id = $this->quizz['module_id'];
            $question = $this->quizz['question'];
            $this->reset('quizz');
            $this->quizz['module_id'] = $module_id;
            $this->quizz['question'] = $question;
            session()->put('quizz_success', true);
        }

    }

    public function addQuestion($id)
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            abort(404);
        }
        $this->quizz['question'] = $quiz->question;
        $this->quizz['module_id'] = $quiz->module->id;
        $this->action = "storeQuestion($id)";
    }


    public function resetAll()
    {
        $this->emit('scrollTop');
        $module_id = $this->quizz['module_id'];
        $this->reset('quizz', 'action', 'selectedAnswer');
        $this->quizz['module_id'] = $module_id;
    }

    public function selectTab($tab)
    {
        $this->emit('selectTab', 'quizz');
    }

    public function storeNewQuiz()
    {
        $validator = Validator::make($this->quizz, [
            'module_id' => 'required',
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
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
            return null;
        }

        $module = Module::find($this->quizz['module_id']);
        if (!$module) {
            abort(404);
        }

        $quiz = Quiz::where('title', $module->title)
                    ->where('module_id', $module->id)
                    ->get()
                    ->first();


        if (!$quiz) {

            $quiz = new Quiz();
            $quiz->title = $module->title;
            $quiz->module_id = $module->id;
            $quiz->save();
        }

        $quizz_question = QuizQuestion::where('quizze_id', $quiz->id)
                                    ->where('question', $this->quizz['question'])
                                    ->get()
                                    ->first();

        if (!$quizz_question) {
            $quizz_question = new QuizQuestion();
            $quizz_question->question = $this->quizz['question'];
            $quizz_question->quizze_id = $quiz->id;
            $quizz_question->save();
        } else {

            $this->addError('question', 'Cette question existe déjà !');
            return null;
        }

        $quizz_answer = new QuizAnswer();
        $quizz_answer->answer = $this->quizz['answer'];
        $quizz_answer->is_valid = $this->quizz['is_answer_true'] === true ? 1 : 0;
        $quizz_answer->quiz_question_id = $quizz_question->id;
        if ($quizz_answer->save()) {
            $this->emit('scrollTop');
            $module_id = $this->quizz['module_id'];
            $this->reset('quizz', 'action');
            $this->quizz['module_id'] = $module_id;
            session()->put('quizz_success', true);
        }
    }

    public function updateQuestion($id)
    {
        $validator = Validator::make($this->quizz, [
            'module_id' => 'required',
            'question' => 'required|string|max:255',
            'answer' => 'nullable|string|max:255',
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
            return null;
        }

        $module = Module::find($this->quizz['module_id']);
        if (!$module) {
            abort(404);
        }

        $quiz = Quiz::where('title', $module->title)
                    ->where('module_id', $module->id)
                    ->get()
                    ->first();


        if (!$quiz) {

            $this->addError('module_id', 'Ce module n\'existe pas !');
            return null;
        }

        $quizz_question = QuizQuestion::where('quizze_id', $quiz->id)
                                    ->where('question', $this->quizz['question'])
                                    ->where('id', $id)
                                    ->get()
                                    ->first();

        if (!$quizz_question) {
            $quizz_question = QuizQuestion::find($id);

            if (!$quizz_question) {
                abort(404);
            }
            $quizz_question->question = $this->quizz['question'];
            $quizz_question->quizze_id = $quiz->id;
            $quizz_question->update();
        }

        $this->actual_question = $quizz_question;

        if ($this->quizz['answer']) {

            $quizz_answer = new QuizAnswer();
            $quizz_answer->answer = $this->quizz['answer'];
            $quizz_answer->is_valid = $this->quizz['is_answer_true'] === true ? 1 : 0;
            $quizz_answer->quiz_question_id = $quizz_question->id;
            $quizz_answer->save();
        }

        $this->emit('scrollTop');
        $module_id = $this->quizz['module_id'];
        $question = $this->quizz['question'];
        $this->reset('quizz');
        $this->quizz['module_id'] = $module_id;
        $this->quizz['question'] = $question;
        session()->put('quizz_success', true);


    }

    public function updateAnswer($id)
    {
        $validator = Validator::make($this->quizz, [
            'module_id' => 'required',
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
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
            return null;
        }

        $module = Module::find($this->quizz['module_id']);
        if (!$module) {
            abort(404);
        }

        $quiz = Quiz::where('title', $module->title)
                    ->where('module_id', $module->id)
                    ->get()
                    ->first();


        if (!$quiz) {

            $this->addError('module_id', 'Ce quizz n\'existe pas !');
            return null;
        }

        $quizz_question = QuizQuestion::where('quizze_id', $quiz->id)
                                    ->where('question', $this->quizz['question'])
                                    ->get()
                                    ->first();

        if (!$quizz_question) {
            $this->addError('question', 'Cette question n\'existe pas !');
            return null;
        }


        $quizz_answer = QuizAnswer::find($id);
        if ($quizz_answer) {

            if ($quizz_answer->answer !== $this->quizz['answer']) {

                $quizz_answer->answer = $this->quizz['answer'];
                $quizz_answer->is_valid = $this->quizz['is_answer_true'] === true ? 1 : 0;
                $quizz_answer->quiz_question_id = $quizz_question->id;
                $quizz_answer->update();

            }
        } else {
            $this->addError('answer', 'Cette réponse n\'existe pas !');
            return null;
        }

        $this->actual_question = $quizz_question;
        $this->emit('scrollTop');
        $module_id = $this->quizz['module_id'];
        $question = $this->quizz['question'];
        $this->reset('quizz', 'selectedAnswer');
        $this->quizz['module_id'] = $module_id;
        $this->quizz['question'] = $question;
        session()->put('quizz_success', true);
        $id_queston = $this->actual_question->id;
        $this->action = "updateQuestion($id_queston)";

    }

    public function deleteAnswer($id)
    {
        $quizz_answer = QuizAnswer::find($id);
        // dd($quizz_answer);
        if ($quizz_answer) {
            $quizz_answer->delete();
        }
    }

    public function deleteQuestion($id)
    {
        $quizz_question = QuizQuestion::find($id);
        // dd($quizz_answer);
        if ($quizz_question) {
            $quizz_question->delete();
        }
    }

    public function deleteQuiz($id)
    {
        $quizz = Quiz::find($id);
        // dd($quizz_answer);
        if ($quizz) {
            $quizz->delete();
        }
    }

    public function mount($formation)
    {
        $this->formation = $formation;
        $first_module = Module::where('formation_id', $this->formation->id ?? 0)
                        ->get()->first();

        $this->quizz['module_id'] = $first_module->id ?? 0;
        $this->emit('scrollTop');
        session()->forget('quizz_success');
        // dd($this->quizz);
    }

    public function render()
    {
        return view('livewire.formation.update-formation.update-quizz', [
            'modules' => Module::where('formation_id', $this->formation->id ?? 0)
                                ->get(),
            'quizzes' => Quiz::wherehas('module', function ($q) {
                                $q->where('formation_id', $this->formation->id ?? 0);
                            })->get(),
            'count_quizzes' => Quiz::where('module_id', $this->actual_selected_module->id ?? 0)
                    ->get()
                    ->count(),
        ]);
    }
}
