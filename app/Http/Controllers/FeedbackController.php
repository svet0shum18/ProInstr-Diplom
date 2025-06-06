<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackMail;

class FeedbackController extends Controller
{
    public function send(Request $request) {

        $validated = $request->validate([
            'email' => 'required|email',
            'message' => 'required|string|min:10|max:2000',
        ]);
        
        Mail::to('cvetlanaacikova@gmail.com')->send(new FeedbackMail($validated));

        return response()->json([
        'success' => true,
        'message' => 'Сообщение успешно отправлено!'
    ]);
        
       
    }
    }

