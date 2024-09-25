<?php

namespace App\Http\Controllers;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendWelcomeEmail() {
        $toEmail = 'emperor.khay17@gmail.com';
        $emailMessage = 'Mailer now works!!!';
        $emailSubject = 'Welcome Email';

        Mail::to($toEmail)->send(new WelcomeMail($emailMessage, $emailSubject));

        return response()->json(['message' => 'Email sent successfully!']);
    }
}
