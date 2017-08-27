<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Jobs\NewContactUsMessageJob;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(StoreContactRequest $request)
    {
        $newContact = Contact::create($request->all());
        dispatch(new NewContactUsMessageJob($newContact));
        return redirect('/')->withSuccess('Pesan anda sudah terkirim, tim kami akan segera merespon anda');
    }
}
