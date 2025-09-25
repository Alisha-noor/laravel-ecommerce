<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:1000',
        ]);

        // Save in DB
        Message::create($validated);

        // Optional: Send email to admin
        Mail::raw("New Message from: {$validated['name']} ({$validated['email']})\n\nSubject: {$validated['subject']}\n\nMessage:\n{$validated['message']}", function ($mail) {
            $mail->to('aleeshanoor@gmail.com') // apna admin email lagana
                ->subject('New Contact Form Message');
        });

        return back()->with('success', 'Thank you! Your message has been sent.');

        // Auto reply banayein
        $autoReply = "👋 Thanks for reaching out! Our team will reply soon.";

        // Dynamic reply based on keywords (optional)
        if (stripos($validated['message'], 'price') !== false) {
            $autoReply = "💰 Our bags start from Rs. 3000.";
        } elseif (stripos($validated['message'], 'location') !== false) {
            $autoReply = "📍 We are located at Atrium Mall, Karachi.";
        }

        return response()->json([
            'success' => true,
            'reply'   => "✅ Thanks! Your message has been received. We'll reply soon."
        ]);
    }
}
