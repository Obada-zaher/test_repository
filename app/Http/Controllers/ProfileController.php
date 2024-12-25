<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

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

    public function index()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // تحديث الحقول النصية
        $user->fill($request->validated());

        // التحقق من تعديل البريد الإلكتروني وإعادة ضبط حالة التحقق
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // التحقق من وجود صورة مرفوعة
        if ($request->hasFile('image')) {
            try {
                $imagePath = $request->file('image')->store('profile_images', 'public');
                $user->image = $imagePath;
            } catch (\Exception $e) {
                Log::error('Error saving image: ' . $e->getMessage());
            }
        }

        // حفظ التغييرات
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function removeImage(Request $request)
    {
        $user = $request->user();
        $user->image = null;
        $user->save();
        return Redirect::route('profile.edit')->with('status', 'profile-image-removed');
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
}
