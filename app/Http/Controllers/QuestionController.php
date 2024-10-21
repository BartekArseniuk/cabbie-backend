<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return response()->json($questions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'question' => 'required',
            'answer' => 'required',
        ]);
        $question = Question::create($request->all());
        return response()->json(['message' => 'Pytanie zostało dodane', 'question' => $question]);
    }

    public function update(Request $request, Question $question)
    {
        $request->validate(['question' => 'required', 'answer' => 'required']);
        $question->update($request->all());
        return response()->json(['message' => 'Pytanie zostało zaktualizowane', 'question' => $question]);
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json(['message' => 'Pytanie zostało usunięte']);
    }
}