<?php

namespace App\Http\Controllers;

use App\Models\PersonalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PersonalInfoController extends Controller
{
    public function store(Request $request)
    {
        // Log the incoming request data
        Log::info('Received personal info request:', $request->all());

        // Validate request
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:personal_info,email',
            'streetAddress' => 'nullable|string|max:255',
            'apt' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zipCode' => 'nullable|string|max:10',
            'phone' => 'nullable|string|min:10|max:15',
            'contactPreference' => 'required|in:email,phone',
            'selection' => 'required|integer|in:0,1,2', // Add validation for selection field
        ]);

        // Log validation results
        if ($validator->fails()) {
            Log::warning('Validation failed:', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create new personal info record
        try {
            $personalInfo = PersonalInfo::create([
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'email' => $request->email,
                'street_address' => $request->streetAddress,
                'apt' => $request->apt,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zipCode,
                'phone' => $request->phone,
                'contact_preference' => $request->contactPreference,
                'selection' => $request->selection, // Add selection to data creation
            ]);

            Log::info('Personal info saved successfully:', $personalInfo->toArray());
            return response()->json(['message' => 'Personal info saved successfully!'], 201);
        } catch (\Exception $e) {
            // Log exception details
            Log::error('Error saving personal info:', ['exception' => $e->getMessage()]);
            return response()->json(['message' => 'An error occurred while saving the personal info.'], 500);
        }
    }
}
