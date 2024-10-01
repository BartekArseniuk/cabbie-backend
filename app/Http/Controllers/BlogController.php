<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::all();
        return response()->json($blogs);
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    public function store(Request $request)
    {
        $currentBlogCount = Blog::count();
        if ($currentBlogCount >= 9) {
            return response()->json([
                'message' => 'Maksymalna liczba aktualności została osiągnięta. Możesz mieć maksymalnie 9 aktualności.',
            ], 403);
        }
        
        // Walidacja (bez wymogu daty)
        $validatedData = $request->validate([
            'image_base64' => 'required|string',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
        ], [
            'image_base64.required' => 'Tło jest wymagane.',
            'title.required' => 'Tytuł jest wymagany.',
            'author.required' => 'Autor jest wymagany.',
            'content.required' => 'Treść jest wymagana.',
        ]);

        // Tworzenie nowego wpisu blogowego (bez pola daty)
        $blog = Blog::create([
            'image_base64' => $validatedData['image_base64'],
            'title' => $validatedData['title'],
            'author' => $validatedData['author'],
            'content' => $validatedData['content'],
        ]);

        return response()->json([
            'message' => 'Wpis blogowy został dodany pomyślnie!',
            'blog' => $blog
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        // Walidacja (bez wymogu daty)
        $validatedData = $request->validate([
            'image_base64' => 'nullable|string',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
        ], [
            'image_base64.required' => 'Tło jest wymagane.',
            'title.required' => 'Tytuł jest wymagany.',
            'author.required' => 'Autor jest wymagany.',
            'content.required' => 'Treść jest wymagana.',
        ]);

        // Aktualizacja danych bloga (bez pola daty)
        $blog->update(array_filter($validatedData));

        return response()->json([
            'message' => 'Wpis blogowy został zaktualizowany pomyślnie!',
            'blog' => $blog
        ]);
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return response()->json([
            'message' => 'Wpis blogowy został usunięty pomyślnie!'
        ]);
    }
}
