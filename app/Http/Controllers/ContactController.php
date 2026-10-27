<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller {

    public function index() {
        return view('store.contact');
    }

    public function store(Request $request) {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($request->only(['name','email','phone','subject','message']));

        return back()->with('success', 'Your message has been sent! We will reply within 24 hours.');
    }
}