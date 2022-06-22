<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class VerifyEmailController extends Controller
{

    public function __invoke(Request $request): RedirectResponse
    {

        $user = User::find($request->route('id')); //takes user ID from verification link. Even if somebody would hijack the URL, signature will be fail the request
        if ($user->hasVerifiedEmail()) {
            $message = __('Your account has been block please contact with admin.');

            return redirect('login')->with('error', $message); //if user is already logged in it will redirect to the dashboard page

            // return redirect()->intended(config('fortify.home') . '?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            $user->update(['active' => '1']);
            event(new Verified($user));
        }

        $message = __('Your email has been verified.');

        return redirect('login')->with('success', $message); //if user is already logged in it will redirect to the dashboard page
    }




    public function resend(Request $request)
    {

        if ($request->input('email')) {
            $user = User::where('email', '=', $request->input('email'))->first();
        }
        // $user->sendEmailVerificationNotification();

        // if ($user->hasVerifiedEmail()) {
        //     dd($this->redirectPath());
        //     return redirect($this->redirectPath());
        // }

        $email =  $user->sendEmailVerificationNotification();
        if ($email) {
            \Session::flash('success', __('Re-send the Email verification link on your email id please check.'));

            return response()->json(['status' => 'success']);
        }
    }
}
