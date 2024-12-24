<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
            $imagePath = $request->file('image')->store('profile_images', 'public'); // حفظ الصورة في التخزين
            $user->image = $imagePath; // تحديث مسار الصورة
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
