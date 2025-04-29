<?php

namespace App\Services\APIService\HRM;


use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

abstract class HRMBaseService
{
    abstract public function sendRequest(): Response;

}
