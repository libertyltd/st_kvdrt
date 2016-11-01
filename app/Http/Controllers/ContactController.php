<?php

namespace App\Http\Controllers;

use App\Contact;
use Validator;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function __construct() {
        $this->middleware('permission:'.Contact::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Contacts = Contact::paginate(20);
        return view('backend.contacts.list', ['list' => $Contacts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.contacts.form', [
            'nameAction' => 'Новая контактная запись',
            'controllerPathList' => '/home/contacts/',
            'controllerAction' => 'add',
            'controllerEntity' => new Contact()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:contacts|max:255',
            'phone' => 'required|unique:contacts|max:16',
            'facebook_link' => 'max:255',
            'instagram_link' => 'max:255',
            'address' => 'required|unique:contacts|max:255',
            'longitude' => 'max:255',
            'latitude' => 'max:255'
        ]);

        if ($validator->fails()) {
            return redirect('/home/contacts/create/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        try {
            DB::transaction(function () use($request) {
                if ($request->status == 1) {
                    $ActiveContacts = Contact::where('status', 1)->get();
                    foreach ($ActiveContacts as $activeContact) {
                        $activeContact->status = 0;
                        $activeContact->save();
                    }
                } else {
                    /* Смотрим на наличие записей в контактах, если их нет, то автоматически делаем эту запись активной */
                    $AllContacts = Contact::all();
                    if ($AllContacts->count() < 1) {
                        $request->status = 1;
                    }
                }

                $Contact = new Contact();
                $Contact->email = $request->email;
                $Contact->phone = $request->phone;
                $Contact->facebook_link = $request->facebook_link;
                $Contact->instagram_link = $request->instagram_link;
                $Contact->address = $request->address;
                $Contact->status = $request->status;
                $Contact->longitude = $request->longitude;
                $Contact->latitude = $request->latitude;
                $Contact->save();

                return true;
            });
        } catch (Exception $e) {
            return redirect('/home/contacts/create/')->with(['errors' => [$e->getMessage()]]);
        }

        return redirect('/home/contacts/')->with(['success'=>['Запись с контактной информацией добавлена!']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::find($id);
        return view('backend.contacts.view', [
            'nameAction' => $contact->email.' '.$contact->phone,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'facebook_link' => $contact->facebook_link,
            'instagram_link' => $contact->instagram_link,
            'address' => $contact->address,
            'longitude' => $contact->longitude,
            'latitude' => $contact->latitude,
            'controllerPathList' => '/home/contacts/'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = Contact::find($id);
        return view ('backend.contacts.form', [
            'email' => $contact->email,
            'phone' => $contact->phone,
            'facebook_link' => $contact->facebook_link,
            'instagram_link' => $contact->instagram_link,
            'address' => $contact->address,
            'status' => $contact->status,
            'longitude' => $contact->longitude,
            'latitude' => $contact->latitude,


            'nameAction' => $contact->email.' '.$contact->phone,
            'idEntity' => $contact->id,
            'controllerPathList' => '/home/contacts/',
            'controllerAction' => 'edit',
            'controllerEntity' => new Contact(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255',
            'phone' => 'required|max:16',
            'facebook_link' => 'max:255',
            'instagram_link' => 'max:255',
            'address' => 'required|max:255',
            'longitude' => 'max:255',
            'latitude' => 'max:255'
        ]);


        if ($validator->fails()) {
            return redirect('/home/contacts/'.$id.'/edit/')->withInput()->withErrors($validator);
        }

        if (!$request->status) {
            $request->status = 0;
        } else {
            $request->status = 1;
        }

        if ($request->status == 1) {
            $ActiveContacts = Contact::where('status', 1)->get();
            foreach ($ActiveContacts as $activeContact) {
                $activeContact->status = 0;
                $activeContact->save();
            }
        }

        try {
            $contact = Contact::find($id);
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->facebook_link = $request->facebook_link;
            $contact->instagram_link = $request->instagram_link;
            $contact->address = $request->address;
            $contact->longitude = $request->longitude;
            $contact->latitude = $request->latitude;
            if ($contact->status > $request->status) {
                throw new Exception('Невозможно выключить единственную контактную запись');
            }
            $contact->status = $request->status;
            $contact->save();
        } catch (Exception $e) {
            return redirect('/home/contacts/'.$contact->id.'/edit/')->with(['errors'=>[$e->getMessage()]]);
        }


        return redirect('/home/contacts/'.$contact->id.'/edit/')->with(['success'=>['Контактная запись изменена']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        if ($contact->status) {
            return redirect('/home/contacts/')->with(['errors' => ['Невозможно удалить активную запись.']]);
        }

        $nameOfDelete = $contact->email.' '.$contact->phone;
        $contact->delete();
        return redirect('/home/contacts/')->with(['success'=>[$nameOfDelete.' успешно удален!']]);
    }
}
