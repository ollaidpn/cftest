<?php

namespace App\Http\Livewire\AddFormation;

use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class StoreQuizz extends Component
{

    public $quizz = [
        // 'module_id' => '',
        'question' => '',
        'answer' => '',
        'is_answer_true' => 'false',
        'module_id' => '',
    ];

    public $actual_question, $actual_selected_module, $update;

    public function finished()
    {
        if (session('details_success') && session('about_success') && session('module_success') && session('quizz_success')) {
            session()->flash('formation_success', 'Le cours a été enregistré avec succès !');
            session()->put('details_success', false);
            session()->put('about_success', false);
            session()->put('module_success', false);
            session()->put('quizz_success', false);

        } else if (session('details_success') === false || session('about_success') === false || session('module_success') === false || session('quizz_success') === false) {
            session()->flash('formation_error', 'Le cours a été enregistré avec succès !');
        }
        return redirect(route('admin.formations.create'));
    }

    public function selectTab($tab)
    {
        $this->emit('selectTab', 'quizz');
    }

    public function storeQuizz()
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
            $this->emit('refreshIndex');
            session()->put('quizz_success', false);
            return null;
        }

        $module = Module::find($this->quizz['module_id']);
        if (!$module) {
            abort(404);
        } else {
            $this->actual_selected_module = $module;
        }

        // $this->emit('test', $this->actual_selected_module);

        $quiz = Quiz::where('title', $this->actual_selected_module->title)
                    ->where('module_id', $this->actual_selected_module->id)
                    ->get()
                    ->first();


        if (!$quiz) {

            $quiz = new Quiz();
            $quiz->title = $this->actual_selected_module->title;
            $quiz->module_id = $this->actual_selected_module->id;
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
        }

        $this->actual_question = $quizz_question;

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

    public function delete($id)
    {
        $quizz_answer = QuizAnswer::find($id);
        // dd($quizz_answer);
        if ($quizz_answer) {
            $quizz_answer->delete();
        }
    }

    public function mount()
    {
        $first_module = Module::where('formation_id', session('actual_formation')->id ?? 0)
                        ->get()->first();

        $this->quizz['module_id'] = $first_module->id ?? 0;
        $this->emit('scrollTop');
        session()->forget('quizz_success');
    }

    public function render()
    {
        return view('livewire.formation.store-quizz', [
            'modules' => Module::where('formation_id', session('actual_formation')->id ?? 0)
                                ->get(),
            'quizzes' => Quiz::wherehas('module', function ($q) {
                                $q->where('formation_id', session('actual_formation')->id ?? 0);
                            })->get(),
            'count_quizzes' => Quiz::where('module_id', $this->actual_selected_module->id ?? 0)
                    ->get()
                    ->count(),
        ]);
    }
}
