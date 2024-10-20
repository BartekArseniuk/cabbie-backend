<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('questions')->get();
        return response()->json($sections);
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required']);
        $section = Section::create($request->all());
        return response()->json(['message' => 'Sekcja została dodana', 'section' => $section]);
    }

    public function show(Section $section)
    {
        $section->load('questions');
        return response()->json($section);
    }

    public function update(Request $request, Section $section)
    {
        $request->validate(['title' => 'required']);
        $section->update($request->all());
        return response()->json(['message' => 'Sekcja została zaktualizowana', 'section' => $section]);
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return response()->json(['message' => 'Sekcja została usunięta']);
    }
}