<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // Get the user instance from the request
        $user = $this->guard()->user();

        // Update the password for the user instance
        $this->setUserPassword($user, $request->password);

        // Update the password for the adviser related to this user
        $adviser = $user->adviser;
        if ($adviser) {
            $adviser->password = Hash::make($request->password);
            $adviser->save();
        }

        event(new PasswordReset($user));

        $this->guard()->login($user);

        return redirect($this->redirectPath())
                            ->with('status', trans('passwords.reset'));
    }
}
