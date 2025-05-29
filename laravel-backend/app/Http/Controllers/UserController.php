<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserCar;

class UserController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageData = base64_encode(file_get_contents($file));
            $user->image = $imageData;
            $user->save();
        }

        return response()->json([
            'message' => 'Image uploaded',
            'image' => $user->image
        ]);
    }

    public function bookTestDrive(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'test_drive_date' => 'required|date',
            'test_drive_time' => 'required',
        ]);

        $validated['user_id'] = $user->id;

        $booking = UserCar::create($validated);

        return response()->json([
            'message' => 'Test drive booked successfully!',
            'data' => $booking,
        ], 201);
    }

    public function getUserCars(Request $request)
    {
        $user = $request->user();

        $bookings = UserCar::with('car')
            ->where('user_id', $user->id)
            ->get();

        return response()->json($bookings);
    }
}
