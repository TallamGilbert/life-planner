<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdateUserPreferencesRequest;
use App\Models\ActivityLog;
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
        $user = $request->user();
        $user->load('preferences');

        return view('profile.edit', [
            'user' => $user,
            'preferences' => $user->preferences ?? $user->preferences()->create([
                'timezone' => config('app.timezone', 'UTC'),
                'email_notifications_enabled' => true,
                'email_summary_enabled' => true,
                'email_summary_frequency' => 'weekly',
            ]),
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

            // Track old values for activity log
            $oldValues = $user->only(['name', 'email', 'bio', 'location', 'phone']);

            $user->fill($validated);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            // Log activity
            $changes = [];
            foreach ($oldValues as $key => $oldValue) {
                if ($user->$key !== $oldValue) {
                    $changes[$key] = [
                        'old' => $oldValue,
                        'new' => $user->$key,
                    ];
                }
            }

            if (!empty($changes) || $request->hasFile('profile_picture')) {
                ActivityLog::log(
                    'profile_updated',
                    'User updated their profile information',
                    'User',
                    $user->id,
                    $changes
                );
            }

            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            \Log::error('Profile update error: ' . $e->getMessage());
            return Redirect::route('profile.edit')->withErrors(['error' => 'An error occurred while updating your profile. Please try again.']);
        }
    }

    /**
     * Update user preferences.
     */
    public function updatePreferences(UpdateUserPreferencesRequest $request): RedirectResponse
    {
        try {
            $user = $request->user();
            $validated = $request->validated();

            $preferences = $user->preferences ?? $user->preferences()->create([
                'timezone' => config('app.timezone', 'UTC'),
                'email_notifications_enabled' => true,
                'email_summary_enabled' => true,
                'email_summary_frequency' => 'weekly',
            ]);

            // Track old values for activity log
            $oldValues = $preferences->only(array_keys($validated));

            $preferences->update($validated);

            // Log activity
            $changes = [];
            foreach ($validated as $key => $newValue) {
                if (($oldValues[$key] ?? null) !== $newValue) {
                    $changes[$key] = [
                        'old' => $oldValues[$key] ?? null,
                        'new' => $newValue,
                    ];
                }
            }

            if (!empty($changes)) {
                ActivityLog::log(
                    'preferences_updated',
                    'User updated their preferences',
                    'UserPreference',
                    $preferences->id,
                    $changes
                );
            }

            return Redirect::route('profile.edit')->with('status', 'preferences-updated');
        } catch (\Exception $e) {
            \Log::error('Preferences update error: ' . $e->getMessage());
            return Redirect::route('profile.edit')->withErrors(['error' => 'An error occurred while updating your preferences. Please try again.']);
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

            ActivityLog::log(
                'profile_picture_deleted',
                'User deleted their profile picture',
                'User',
                $user->id
            );
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

        ActivityLog::log(
            'account_deleted',
            'User deleted their account',
            'User',
            $user->id
        );

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

