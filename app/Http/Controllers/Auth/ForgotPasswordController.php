<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\FrontUser;
use Illuminate\Support\Facades\Request;

class ForgotPasswordController extends Controller
{

    public function getEmail()
    {
        return view('auth.front.forgotpassword');
    }

    public function postEmail()
    {
        $this->validate(request(), [
            'email' => 'required|email',
        ]);

        $user = FrontUser::where('email', request('email'))->first();

        if(count($user) > 0) {
          $to = request('email');

          $subject = trans('auth.forgotpass.subject');

          session()->put(['code' => str_random(10), 'user_id' => $user->id]);

          $message = trans('auth.forgotpass.message').session('code');
          $headers  = 'MIME-Version: 1.0' . "\r\n";
          $headers .= 'Content-type: text; charset=utf-8' . "\r\n";

          mail($to, $subject, $message, $headers);

          return redirect()->route('password.code')->withSuccess(trans('auth.forgotpass.code'));
        } else {
          return back()->withErrors(['invalidEmail' => [trans('auth.forgotpass.email')]]);
        }
    }

    public function getCode()
    {
        return view('auth.front.code');
    }

    public function postCode()
    {
        $this->validate(request(), [
            'code' => 'required|in:'.session('code')
        ]);

        return redirect()->route('password.reset')->withSuccess(trans('auth.forgotpass.codeSuccess'));
    }

    public function getReset()
    {
        return view('auth.front.resetpassword');
    }

    public function postReset()
    {
        $this->validate(request(), [
            'password' => 'required|min:3',
            'passwordRepeat' => 'required|same:password',
        ]);

        $user = FrontUser::find(session('user_id'));

        if(count($user) > 0) {
          $user->password = bcrypt(request('password'));
          $user->remember_token = request('_token');
          $user->save();

          session()->forget('code');
          session()->forget('user_id');

          return redirect()->route('front.login')->withSuccess(trans('auth.forgotpass.pass'));
        } else {
          abort(404);
        }
    }
}
