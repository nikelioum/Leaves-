<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Day;
use App\Models\Leave;
use App\Models\Type;
use App\Models\User;

class LeaveController extends Controller
{
    //Get Leave Counter Days by type from Post
    public function index(Request $request)
    {

        //Get User Id
        $userId = $request->userId;

        //Get type of leave
        $type = $request->type;

        $typeExists = Type::where('id', $type)->exists();

        $userExists = User::where('id', $userId)->exists();

         //Check if both user & type invalid
         if(!$typeExists && !$userExists){
            return response()->json([
                'error' => 'Invalid details. Please provide a valid details'
            ], 400); // 400 Bad Request status code
        }

        // Check if the type exists
        if (!$typeExists) {
            return response()->json([
                'error' => 'Invalid type. Please provide a valid type ID.'
            ], 400); // 400 Bad Request status code
        }

         // Check if the user exists
         if (!$userExists) {
             return response()->json([
                 'error' => 'Invalid user. Please provide a valid user ID.'
             ], 400); // 400 Bad Request status code
         }



        // Retrieve active days for the user
        $activeDays = Day::where('user_id', $userId)
            ->where('status', 'active')
            ->where('type_id', $type)
            ->get();

        // Calculate total available leave days
        $totalDays = 0;
        foreach ($activeDays as $day) {
            $totalDays += $day->duration;
        }

        // Retrieve total number of leave days taken by the user
        $totalLeaveTaken = Leave::where('user_id', $userId)->where('type_id', $type)->sum('days');

        // Calculate remaining leave days
        $remainingDays = $totalLeaveTaken - $totalDays;

        // Retrieve type name
        $typeName = Type::find($type)->name;

        return response()->json([
            'type' => $typeName,
            'remaining_days' => $remainingDays
        ]);
    }
}
