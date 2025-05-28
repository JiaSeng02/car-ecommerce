<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
