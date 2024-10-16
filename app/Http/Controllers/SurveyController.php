<?php

namespace App\Http\Controllers;

use App\Models\SurveyAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function submitSurvey(Request $request)
    {
        $request->validate([
            'isDriver' => 'required|string',
            'carType' => 'required|string',
            'taxiRegistry' => 'nullable|string',
            'jobStatus' => 'required|string',
            'startTime' => 'required|string',
            'weeklyHours' => 'required|string',
            'foundVia' => 'required|string',
        ]);

        $user = Auth::user();

        SurveyAnswer::updateOrCreate(
            ['user_id' => $user->id],
            $request->only('isDriver', 'carType', 'taxiRegistry', 'jobStatus', 'startTime', 'weeklyHours', 'foundVia')
        );

        $user->update(['is_first_login' => false]);

        return response()->json(['message' => 'Survey submitted successfully']);
    }

    public function getSurveyByUserId($userId)
    {
        $surveyAnswer = SurveyAnswer::where('user_id', $userId)->first();

        if (!$surveyAnswer) {
            return response()->json(['message' => 'No survey found for the specified user'], 404);
        }

        return response()->json($surveyAnswer);
    }
}