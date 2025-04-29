<?php

namespace App\Services\EmailService;

interface EmailServiceInterface
{
    public function send($to, $subject, $body);
}
