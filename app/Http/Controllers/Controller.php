<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[
    OA\Info(version: "1.0.0", description: "UStudy Project Documentation", title: "UStudy Project Documentation"),
    OA\Server(url: 'http://localhost:8000/api', description: "local server"),
    OA\SecurityScheme(securityScheme: 'sanctum', type: "apiKey", name: "Authorization", in: "header", description:"Token kiritishda 'Bearer {token}' formatidan foydalaning"),
]

abstract class Controller
{
    //
}
