<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $role = $user->getRoleNames()->first();

        // Direct to role-specific profile edit view
        switch ($role) {
            case 'club_admin':
                return view('club.profile.edit', ['user' => $user]);

            case 'player':
            default:
                return view('profile.edit', ['user' => $user]);
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // Handle avatar upload if provided
        if ($request->hasFile('avatar')) {
            // Optional: delete old avatar if it exists
            if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        // Update user fields
        $user->fill($data);

        // Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Route back to different profile views based on role
        if ($user->hasRole('club_admin')) {
            return Redirect::route('club.profile.edit')->with('status', 'profile-updated');
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's avatar.
     * Roles: club_admin / player
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = $request->user();

        // Delete old avatar from S3 if exists
        if ($user->avatar) {
            Storage::disk('s3')->delete($user->avatar);
        }

        // Resize avatar using Intervention
        $image = Image::make($request->file('avatar'))->fit(300, 300); // 300x300 avatar

        // Create unique filename
        $filename = 'avatars/' . uniqid() . '.png';

        // Convert image to stream
        $stream = $image->stream('png');

        // Upload to S3
        $uploaded = Storage::disk('s3')->put($filename, $stream->__toString());

        if ($uploaded) {
            Storage::disk('s3')->setVisibility($filename, 'public');

            // Save the avatar path in DB
            $user->avatar = $filename;
            $user->save();
        }

        $route = $user->hasRole('club_admin') ? 'club.profile.edit' : 'profile.edit';
        return redirect()->route($route)->with('success', 'Avatar updated successfully.');
    }

}
