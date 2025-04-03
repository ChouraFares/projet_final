<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    //Undefined type 'Illuminate\Foundation\Auth\SendsPasswordResetEmails'.intelephense(P1009)

    use SendsPasswordResetEmails;
}
