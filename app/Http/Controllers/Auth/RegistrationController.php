<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\FrontUser;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Models\UserField;

class RegistrationController extends Controller
{

    public function create()
    {
        $userfields = UserField::where('in_register', 1)->get();

        return view('auth.front.register', compact('userfields'));
    }

    public function store()
    {
        $toValidate = [];

        $client = new Client;
        $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => env('RE_CAP_SECRET'),
                    'response' => request('g-recaptcha-response'),
                    'remoteip' => request()->ip()
                ]
        ]);

        if(!json_decode($response->getBody())->success) {
            $toValidate['captcha'] = 'required';
        }

        $uniquefields = UserField::where('in_register', 1)->where('unique_field', 1)->where('required_field', 1)->get();

        if(count($uniquefields) > 0) {
            foreach ($uniquefields as $uniquefield) {
                if($uniquefield->field == 'email') {
                    $toValidate[$uniquefield->field] = 'required|unique:front_users|email';
                } else {
                    $toValidate[$uniquefield->field] = 'required|unique:front_users';
                }
            }
        }

        $requiredfields = UserField::where('in_register', 1)->where('required_field', 1)->where('unique_field', 0)->get();

        if(count($requiredfields) > 0) {
            foreach ($requiredfields as $requiredfield) {
                if($requiredfield->field == 'name' || $requiredfield->field == 'surname') {
                    $toValidate[$requiredfield->field] = 'required|min:3';
                } else {
                    $toValidate[$requiredfield->field] = 'required';
                }
            }
        }

        $toValidate['password'] = 'required|min:4';
        $toValidate['passwordRepeat'] = 'required|same:password';

        $validator = $this->validate(request(), $toValidate);


        $user = FrontUser::create([
            'is_authorized' => 0,
            'lang' => 1,
            'name' => request('name') ? request('name') : '',
            'surname' => request('surname') ? request('surname') : '',
            'email' => request('email') ? request('email') : '',
            'phone' => request('phone') ? request('phone') : '',
            'password' => request('password') ? bcrypt(request('password')) : '',
            'terms_agreement' => request('terms_agreement') ? 1 : 0,
            'promo_agreement' => request('promo_agreement') ? 1 : 0,
            'personaldata_agreement' => request('personaldata_agreement') ? 1 : 0,
            'remember_token' => request('_token')
        ]);

        $to = request('email');

        $subject = trans('auth.register.subject');

        session()->put(['token' => str_random(60), 'user_id' => $user->id]);

        $message = '
          <p>Buna ziua,'.$user->name.' '.$user->surname.'</p>,
          <p>Dvs. v-ati inregistrat pe site-ul '.getContactInfo('site')->translationByLanguage()->first()->value.'</p>.
          <p>1. Redactarea datelor personale</p>
          <p>2. Vizualizarea istoriei de comenzi (inclusiv de a vedea la care etapa de procesare este comanda curenta)</p>
          <p>3. Vizualiazarea produselor din Wishlist</p>
          <p>4. Solicitarea returului pe produse comandate</p>

          <p>Mai jos sunt datele de acces:</p>

          <p>Login: '.$user->email.'</p>
          <p>Parola: '.request('password').'</p>

          <p>Va multumim!</p>
        ';

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        mail($to, $subject, $message, $headers);

        Auth::guard('persons')->login($user);

        if(!empty(request('prev'))) {
            return redirect(request('prev'));
        } else {
            return redirect()->route('home');
        }
    }

    public function authorizeUser($token) {
        if($token == session('token')) {
            $user = FrontUser::find(session('user_id'));

            if(count($user) > 0) {
              session()->forget('token');
              session()->forget('user_id');

              $user->is_authorized = 1;
              $user->save();

              return redirect()->route('home');
            } else {
              abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function changePass($token) {
        if($token == session('token')) {
            $user = FrontUser::find(session('user_id'));

            if(count($user) > 0) {
              $user->is_authorized = 1;
              $user->save();

              return redirect()->route('password.reset');
            } else {
              abort(404);
            }
        } else {
            abort(404);
        }
    }
}
