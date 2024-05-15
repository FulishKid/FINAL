<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationMail;
use Illuminate\Http\Request;
use App\Mail\GreetingMail;
use Illuminate\Support\Facades\Mail;

class SendMSG extends Controller
{
    function sendMSG()
    {
        Mail::to('pavvvelkosss@gmail.com')->send(new RegistrationMail('Helooo', 'https://fulishkid.github.io./'));
    }
}
