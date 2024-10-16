<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (auth()->user()->role !== 'admin' && auth()->user()->id != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if (auth()->user()->role !== 'admin' && auth()->user()->id != $id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $id,
            'phone_number' => 'nullable|string|max:20',
            'pesel' => 'nullable|string|max:11|unique:users,pesel,' . $id,
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:28',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user->first_name = $request->input('first_name', $user->first_name);
        $user->last_name = $request->input('last_name', $user->last_name);
        $user->email = $request->input('email', $user->email);
        $user->phone_number = $request->input('phone_number', $user->phone_number);
        $user->pesel = $request->input('pesel', $user->pesel);
        $user->bank_name = $request->input('bank_name', $user->bank_name);
        $user->bank_account_number = $request->input('bank_account_number', $user->bank_account_number);

        $user->save();

        return response()->json($user, 200);
    }

    public function verifyForm(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'is_form_verified' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user->is_form_verified = $request->input('is_form_verified');
        $user->save();

        return response()->json(['message' => 'Form verification status updated', 'user' => $user], 200);
    }
}