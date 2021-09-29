<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Page;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request) {
        $contacts = Contact::all();

        $page = Page::where('alias', 'contacts')->first();
        $seoData = $this->getSeo($page);

        return view('front.pages.contacts', compact('contacts', 'seoData'));
    }

    // get SEO data for a page
    private function getSeo($page){
        $seo['seo_title'] = $page->translationByLanguage($this->lang->id)->first()->meta_title;
        $seo['seo_keywords'] = $page->translationByLanguage($this->lang->id)->first()->meta_keywords;
        $seo['seo_description'] = $page->translationByLanguage($this->lang->id)->first()->meta_description;

        return $seo;
    }

    public function feedBack(Request $request) {
        $toValidate['fullname'] = 'required|min:4';
        $toValidate['email'] = 'required|email';
        $toValidate['phone'] = 'required';
        $toValidate['message'] = 'required';

        $validator = $this->validate(request(), $toValidate);

        $emailAdmin = getContactInfo('emailadmin');
        $to = [];

        foreach ($emailAdmin->translationByLanguage($this->lang->id)->get() as $email) {
          $to[] = $email->value;
        }

        $to = implode($to, ',');

        $subject = trans('auth.register.subject');

        $message = $request->fullname.' '.$request->email.''.$request->phone.''.$request->message;
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text; charset=utf-8' . "\r\n";

        mail($to, $subject, $message, $headers);

        return redirect()->back()->withSuccess('Message has been sent');
    }

    public function feedBackPopup(Request $request) {

        $validator = validator($request->all(), [
          'fullname' => 'required|min:4',
          'phone' => 'required',
          'company' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 400);
        }

        $emailAdmin = getContactInfo('emailadmin');
        $to = [];

        foreach ($emailAdmin->translationByLanguage($this->lang->id)->get() as $email) {
          $to[] = $email->value;
        }

        // $to = implode($to, ',');
        //
        // $subject = trans('front.feedback.subject');
        //
        // $message = $request->fullname.' '.$request->phone.''.$request->company;
        // $headers  = 'MIME-Version: 1.0' . "\r\n";
        // $headers .= 'Content-type: text; charset=utf-8' . "\r\n";
        //
        // mail($to, $subject, $message, $headers);

        $data['request'] = $request;

        $status = Mail::send('front.emails.feedBackPopup', $data, function($message)
        {
            $message->to('digitalmallmd@gmail.com', 'digitalmall.md')->from('admin@digitalmall.md')->subject(trans('auth.register.subject'));
        });

        return response()->json(trans('front.feedback.success'));
    }
}
