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
        'peserta-tour/create/{$id}',
        'peserta-tour/store/{$id}',
        'peserta-tour/edit/{$id}',
        'peserta-tour/update/{$id}',
        'peserta-tour/destroy/{$id}',
        
        // Roles
        'roles',
        'roles/create',
        'roles/store',
        'roles/edit/{$id}',
        'roles/update/{$id}',
        'roles/destroy/{$id}',
        
        // User Travel
        'user_travel',
        'user_travel/create',
        'user_travel/store',
        'user_travel/edit/{$id}',
        'user_travel/update/{$id}',
        'user_travel/destroy/{$id}',
        'user_travel/create_tour_leader',
        'user_travel/store_tour_leader',
        
        // m_bus
        'm_bus/create',
        'm_bus/store',
        'm_bus',
        'm_bus/edit/{$id}',
        'm_bus/update/{$id}',
        'm_bus/destroy/{$id}',
        'm_bus/13',
        
        // Bus
        'bus',
        'bus/create',
        'bus/store',
        'bus/edit/{$id}',
        'bus/update/{$id}',
        'bus/destroy/{$id}',
        
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
        'users/edit/{$id}',
        'users/update/{$id}',
        'users/destroy/{$id}',
        
        // User Locations
        'user-locations/create',
        'user-locations/store',
        'user-locations/list_user-locations',
    ];
}
