<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $user = $request->user();
            
            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                // Validate file was uploaded successfully
                if (!$request->file('profile_picture')->isValid()) {
                    return Redirect::route('profile.edit')->withErrors(['profile_picture' => 'File upload failed. Please try again.']);
                }
                
                // Delete old profile picture if it exists
                if ($user->profile_picture_path) {
                    Storage::disk('public')->delete($user->profile_picture_path);
                }
                
                // Store new profile picture
                $path = $request->file('profile_picture')->store('profile-pictures', 'public');
                $validated = $request->validated();
                $validated['profile_picture_path'] = $path;
            } else {
                $validated = $request->validated();
            }
            
            $user->fill($validated);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            \Log::error('Profile update error: ' . $e->getMessage());
            return Redirect::route('profile.edit')->withErrors(['error' => 'An error occurred while updating your profile. Please try again.']);
        }
    }

    /**
     * Delete the user's profile picture.
     */
    public function deleteProfilePicture(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($user->profile_picture_path) {
            Storage::disk('public')->delete($user->profile_picture_path);
            $user->update(['profile_picture_path' => null]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-picture-deleted');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete profile picture if it exists
        if ($user->profile_picture_path) {
            Storage::disk('public')->delete($user->profile_picture_path);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
