<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\EmailService\EmailService;
use Illuminate\Http\Request;

class HealthCheckController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'API is working fine.'
        ]);
    }

    public function sendEmail(EmailService $emailService)
    {
        $emailService->send('rakibul.nonditosoft@gmail.com', 'Subject', 'Email body');
        return response()->json([
            'status' => 'success',
            'message' => 'Email sent successfully.'
        ]);
    }

}
