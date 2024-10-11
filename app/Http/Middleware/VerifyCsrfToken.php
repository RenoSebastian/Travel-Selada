<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = 
    [ 
        "/bus/store", 
        '/login', 
        'm_bus/store',
        'user_travel/store',
        'user_travel/{id}/edit',
        'user_travel/{id}',
        'user_travel/store',
        'user_travel/create',
        'middleware/admin/dashboard',
        '/peserta-tour/store',
        '/locations',
        '/peserta-tour/update/e61cf71c-2e97-46ad-a1db-51e7c27d6b09',
        //
    ];
}
