<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class MessageController extends Controller {

    public function index() {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message) {
        $message->update(['status' => 'read']);
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(ContactMessage $message) {
        $message->delete();
        return response()->json(['success' => true, 'message' => 'Message deleted.']);
    }
}