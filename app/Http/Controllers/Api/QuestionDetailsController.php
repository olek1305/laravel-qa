<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionDetailsResource;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionDetailsController extends Controller
{
    public function __invoke(Question $question)
    {
        $question->increment('views');

        return new QuestionDetailsResource($question);
    }
}
