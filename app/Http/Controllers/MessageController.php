<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\NewMessageReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $message = Message::create($request->all());
        
        // Broadcast notification to admin
        event(new NewMessageReceived($message));

        return redirect()->back()->with('success', 'Terima kasih! Pesan Anda telah berhasil dikirim. Kami akan segera merespons pesan Anda.');
    }
}
