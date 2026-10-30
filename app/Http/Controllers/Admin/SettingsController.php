<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller {

    public function index() {
        $notifyEmails = StoreSetting::get('notification_emails', '');
        $emailList    = array_filter(array_map('trim', explode(',', $notifyEmails)));

        return view('admin.settings.index', compact('emailList'));
    }

    public function addEmail(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);

        $current   = StoreSetting::get('notification_emails', '');
        $emailList = array_filter(array_map('trim', explode(',', $current)));

        if (in_array($request->email, $emailList)) {
            return response()->json(['success' => false, 'message' => 'Email already exists.']);
        }

        $emailList[] = $request->email;
        StoreSetting::set('notification_emails', implode(',', $emailList));

        return response()->json([
            'success' => true,
            'message' => $request->email . ' added successfully.',
            'email'   => $request->email,
        ]);
    }

    public function removeEmail(Request $request) {
        $request->validate(['email' => 'required|email']);

        $current   = StoreSetting::get('notification_emails', '');
        $emailList = array_filter(array_map('trim', explode(',', $current)));
        $emailList = array_values(array_filter($emailList, fn($e) => $e !== $request->email));

        StoreSetting::set('notification_emails', implode(',', $emailList));

        return response()->json(['success' => true, 'message' => 'Email removed.']);
    }
}