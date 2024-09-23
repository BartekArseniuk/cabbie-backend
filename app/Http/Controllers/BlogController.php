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
        $validatedData = $request->validate([
            'image_base64' => 'required|string',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $blog = Blog::create([
            'image_base64' => $validatedData['image_base64'],
            'title' => $validatedData['title'],
            'date' => $validatedData['date'],
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

        $validatedData = $request->validate([
            'image_base64' => 'nullable|string',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

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