<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $articles = Article::where('user_id', $user->id)->where('status', 'published')->get();
        $isCurrentUser = Auth::check() && Auth::id() == $user->id;
        return view('profile.show', compact('user', 'articles', 'isCurrentUser'));
    }

    public function update(ProfileUpdateRequest $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        if ($user->id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $user->fill($request->validated());
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        if ($request->hasFile('image')) {
            try {
                $imagePath = $request->file('image')->store('profile_images', 'public');
                $user->image = $imagePath;
            } catch (\Exception $e) {
                Log::error('Error saving image: ' . $e->getMessage());
            }
        }
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    public function removeImage(Request $request)
    {
        $user = $request->user();
        $user->image = null;
        $user->save();
        return Redirect::route('profile.edit')->with('status', 'profile-image-removed');
    }

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
}
