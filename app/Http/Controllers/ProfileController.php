<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Update user profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'bio' => ['nullable', 'string', 'max:255'],
            'profile_photo' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp',
                'mimetypes:image/jpeg,image/png,image/webp',
                'max:2048',
            ],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->bio = $validated['bio'] ?? null;


        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');

            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($photo->getMimeType(), $allowedMimes)) {
                return back()->withErrors(['profile_photo' => 'Invalid image type. Only JPG, PNG, and WEBP allowed.']);
            }

            $path = $photo->store('profile_photos', 'public');


            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }


            $user->profile_photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
