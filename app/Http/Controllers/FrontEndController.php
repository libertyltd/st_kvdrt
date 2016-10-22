<?php

namespace App\Http\Controllers;

use App\Contact;
use App\FeedBack;
use App\ImageStorage;
use App\Slider;
use Illuminate\Http\Request;

use App\Http\Requests;

class FrontEndController extends Controller
{
    public function index () {
        $contact = Contact::where('status', 1)->first();
        $contacts = [];
        if ($contact) {
            $contacts = [
                'email' => $contact->email,
                'phone' => $contact->phone,
                'phoneToLink' => preg_replace('~\D+~', '', $contact->phone),
                'facebook_link' => $contact->facebook_link,
                'instagram_link' => $contact->instagram_link,
                'address' => $contact->address
            ];
        }

        $slides = Slider::where('status', 1)->get();
        foreach ($slides as &$slide) {
            $IM = new ImageStorage($slide);
            $slide->src = $IM->getCropped('image', 1365, 807)[0];
        }

        $feedbacks = FeedBack::where('status', 1)->get();
        foreach ($feedbacks as &$feedback) {
            $IM = new ImageStorage($feedback);
            $feedback->avatar = $IM->getCropped('avatar', 102, 102)[0];
        }

        return view('index', [
            'contacts' => $contacts,
            'slides' => $slides,
            'feedbacks' => $feedbacks,
        ]);
    }
}
