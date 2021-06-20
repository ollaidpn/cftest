<?php

namespace App\Http\Livewire;

use App\Models\Categorie;
use App\Models\Quiz;
use App\Models\Section;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Learn extends Component
{

    public $formation, $count_videos, $count_quizz, $categories, $all_contents = [], $actual_content = null, $ended_contents = [], $progress = 0, $actual_content_type = 'video';
    public $quiz = [], $answers = [], $question_errors = [], $is_quiz_submitted = false, $suspended_quiz = [], $is_started  = false;

    public function mount($formation)
    {
        $this->categories = Categorie::where('category_parent', null)->get();
        $this->formation = $formation;
        $this->is_started = $formation->did_started;
        $this->count_videos = null;
        if (count($formation->modules) !== 0) {

            foreach ($formation->modules as $module) {

                if (count($module->sections) !== 0) {

                    $this->count_videos += count($module->sections);

                    foreach ($module->sections as $section) {

                        array_push($this->all_contents, ["video" => $section->id]);
                    }

                    if ($module->quiz) {
                        array_push($this->all_contents, ["quiz" => $module->quiz->id]);
                    }
                }
            }
        }

        $this->count_quizz = null;
        if (count($formation->modules) !== 0) {

            foreach ($formation->modules as $module) {

                if ($module->quiz) {

                    $this->count_quizz++;

                }
            }
        }

        if ($this->formation->pivot && $this->formation->pivot->actual_content_id && $this->formation->pivot->actual_content_type) {

            if ($this->formation->pivot->actual_content_type === "video") {

                $section = Section::find($this->formation->pivot->actual_content_id);
                if ($section) {
                    $this->actual_content = $section;
                    $this->actual_content_type = "video";
                } else
                    abort(404);

            } else if ($this->formation->pivot->actual_content_type === "quiz") {

                $quiz = Quiz::find($this->formation->pivot->actual_content_id);
                if ($quiz) {

                    $this->actual_content = $quiz;
                    $this->actual_content_type = "quiz";
                    $this->getValidAnswers();

                } else {
                    abort(404);
                }

            }

        }

        // dd(json_decode($formation->pivot->ended_contents));

        if ($formation->pivot) {

            $this->ended_contents = json_decode($formation->pivot->ended_contents, true);
            $this->suspended_quiz = json_decode($formation->pivot->suspended_quiz, true);
        }

        if (!empty($this->ended_contents) && !empty($this->all_contents) )
            $this->progress = intval((count($this->ended_contents) / count($this->all_contents)) * 100);

        if ( $this->actual_content && $this->actual_content_type === "quiz") {

            $this->ended_contents = json_decode($formation->pivot->ended_contents, true);

        }
            // dd($this->ended_contents);
    }

    public function getValidAnswers()
    {
        // dd(($this->actual_content->questions));
        if ($this->actual_content_type === "quiz" && $this->actual_content && count($this->actual_content->questions) !== 0) {

            foreach ($this->actual_content->questions as $question ) {

                if (count($question->answers) !== 0) {

                    $answers = [];
                    foreach ($question->answers as $answer) {

                        $answer->is_valid == "1" ? array_push($answers, $answer->answer) : "";
                    }
                    $this->quiz[$question->id] = $answers;
                    // dd($answers);
                    $this->answers[$question->id] = [];
                }

            }

        }
    }

    public function markContentAsFinished()
    {
        $formation = $this->formation;
        try {

            if ($this->actual_content) {
                $ended_content = [$this->actual_content_type => $this->actual_content->id];
                $content_already_ended = in_array($ended_content, $this->ended_contents);

                if (!$content_already_ended) {

                    array_push($this->ended_contents, $ended_content);
                    $formation->students()->updateExistingPivot(Auth::user()->id, ['ended_contents' => json_encode($this->ended_contents)]);
                    $this->progress = intval((count($this->ended_contents) / count($this->all_contents)) * 100);
                    if ($this->progress === 100)
                        $formation->students()->updateExistingPivot(Auth::user()->id, ['status' => 'finished']);

                    $formation->students()->updateExistingPivot(Auth::user()->id, ['process' => $this->progress]);
                }
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function selectSection($section)
    {
        $section = Section::find($section['id']);
        if ($section) {

            $this->actual_content = $section;
            $formation = $this->formation;
            $formation->students()->updateExistingPivot(Auth::user()->id, [
                                'actual_content_id' => $section->id,
                                'actual_content_type' => "video",
                            ]);
            $this->actual_content_type = 'video';
        } else {
            abort(404);
        }
        $this->emit('scrollTop');
    }

    public function selectQuiz($id)
    {
        $quiz = Quiz::find($id);
        if ($quiz) {

            $this->actual_content = $quiz;
            $formation = $this->formation;
            $formation->students()->updateExistingPivot(Auth::user()->id, [
                                'actual_content_id' => $quiz->id,
                                'actual_content_type' => "quiz",
                            ]);
            $this->actual_content_type = 'quiz';
            $this->getValidAnswers();
            // dd($this->actual_content);
        } else {
            abort(404);
        }
        $this->emit('scrollTop');

    }

    public function validateQuiz()
    {
        // dd($this->answers);
        $this->question_errors = [];
        $this->is_quiz_submitted = true;
        foreach ($this->answers as $key => $value) {
            // dd(count(array_diff($value, $this->quiz[$key])));
            if (count($value) > count($this->quiz[$key])) {

                array_push($this->question_errors, $key);
            } else {

                if (count(array_diff($this->quiz[$key], $value)) > 0) {
                    array_push($this->question_errors, $key);
                }
            }

        }

        $count_questions = count($this->actual_content->questions);
        $count_invalid_answers = count($this->question_errors);

        $score = intval((($count_questions - $count_invalid_answers) / $count_questions) * 100);
        if ($score > 80) {
            session()->flash('success', 'Vous avez réussi le quiz avec un score de '.$score.'% de bonne réponses.');
            $this->markContentAsFinished();
        }
        else {
            $date = date('Y-m-d H:i:s', strtotime('+1 day'));
            $this->suspended_quiz[$this->actual_content->id] = $date;
            $formation = $this->formation;
            $formation->students()->updateExistingPivot(Auth::user()->id, ['suspended_quiz' => json_encode($this->suspended_quiz)]);
        }
    }

    public function goToNextVideo()
    {
        if (!$this->actual_content) {

            if (array_key_first($this->all_contents[0]) === "video") {

                $section = Section::find($this->all_contents[0]['video']);
                if ($section) {

                    $this->actual_content = $section;
                    $formation = $this->formation;
                    $this->actual_content_type = "video";
                    $formation->students()->updateExistingPivot(Auth::user()->id, [
                            'actual_content_id' => $section->id,
                            'actual_content_type' => "video",
                        ]);

                }

            } else if (array_key_first($this->all_contents[0]) === "quiz") {

                $quiz = Quiz::find($this->all_contents[0]['quiz']);
                if ($quiz) {

                    $this->actual_content = $quiz;
                    $formation = $this->formation;
                    $this->actual_content_type = "quiz";
                    $formation->students()->updateExistingPivot(Auth::user()->id, [
                                'actual_content_id' => $quiz->id,
                                'actual_content_type' => "quiz",
                            ]);
                    $this->getValidAnswers();

                }
            }


        } else {

            $actual_content_key = array_search([$this->actual_content_type => $this->actual_content->id], $this->all_contents);
            if ($actual_content_key !== false && array_key_exists($actual_content_key+1, $this->all_contents)) {

                if ($this->all_contents[$actual_content_key+1] && array_key_first($this->all_contents[$actual_content_key+1]) === "video") {

                    $section = Section::find($this->all_contents[$actual_content_key+1]['video']);
                    if (($section && $section->module->id === $this->actual_content->module->id) || ($section && $section->module->id !== $this->actual_content->module->id && in_array(["quiz" => $this->actual_content->module->quiz->id], $this->ended_contents))) {

                        $this->actual_content = $section;
                        $formation = $this->formation;
                        $this->actual_content_type = "video";
                        $formation->students()->updateExistingPivot(Auth::user()->id, [
                                'actual_content_id' => $section->id,
                                'actual_content_type' => "video",
                            ]);
                    }

                } else  if ($this->all_contents[$actual_content_key+1] && array_key_first($this->all_contents[$actual_content_key+1]) === "quiz") {

                    $quiz = Quiz::find($this->all_contents[$actual_content_key+1]['quiz']);
                    if (($quiz && $quiz->module->id === $this->actual_content->module->id) || ($quiz && $quiz->module->id !== $this->actual_content->module->id && in_array(["quiz" => $this->actual_content->module->quiz->id], $this->ended_contents))) {

                        $this->actual_content = $quiz;
                        $formation = $this->formation;
                        $this->actual_content_type = "quiz";
                        $formation->students()->updateExistingPivot(Auth::user()->id, [
                                'actual_content_id' => $quiz->id,
                                'actual_content_type' => "quiz",
                            ]);
                        $this->getValidAnswers();

                    }
                }


            }
        }
        $this->emit('scrollTop');
    }

    public function beginFormation()
    {
        Auth::user()->formations()->attach($this->formation, ['status' => 'in process']);
        $this->is_started = true;
        $this->emit('scrollTop');
    }

    public function render()
    {
        $this->emit('refresh');
        return view('livewire.formation.learn');
    }
}
