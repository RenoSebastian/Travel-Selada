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
    protected $except = [
        // Peserta Tour
        'peserta-tour',
        'peserta-tour/create/*',
        'peserta-tour/store/*',
        'peserta-tour/edit/*',
        'peserta-tour/update/*',
        'peserta-tour/destroy/*',
        
        // Roles
        'roles',
        'roles/create',
        'roles/store',
        'roles/edit/*',
        'roles/update/*',
        'roles/destroy/*',
        
        // User Travel
        'user_travel',
        'user_travel/create',
        'user_travel/store',
        'user_travel/edit/*',
        'user_travel/update/*',
        'user_travel/destroy/*',
        'user_travel/create_tour_leader',
        'user_travel/store_tour_leader',
        
        // m_bus
        'm_bus/create',
        'm_bus/store',
        'm_bus',
        'm_bus/edit/{$id}',
        'm_bus/update/*',
        'm_bus/destroy/*',
        'm_bus/13',
        
        // Bus
        'bus',
        'bus/create',
        'bus/store',
        'bus/edit/*',
        'bus/update/*',
        'bus/destroy/*',
        
        // Login
        '/',
        '/login',
        '/logout',
        '/register',
        
        // Dashboard Admin & User
        'admin/dashboard',
        'user/dashboard',
        
        // Locations
        'locations',
        'locations/list/Bus',
        'locations/create',
        'locations/store',
        
        // Users
        'users/create',
        'users/store',
        'users/list_user',
        'users/edit/*',
        'users/update/*',
        'users/destroy/*',
        
        // User Locations
        'user-locations/create',
        'user-locations/store',
        'user-locations/list_user-locations',
    ];
}
