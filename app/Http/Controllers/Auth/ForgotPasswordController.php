<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showEmailForm() {
        return view('auth.email-forgot');
    }
    public function showForgotPasswordForm()
    {
        return view('auth.form-forgot');
    }
}
