<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserLocation extends Model
{

    protected $connection = 'pgsql_mireta';
    protected $table = 'public.user_locations';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'brand_id',
        'location_id',
        'created_at',
        'updated_at'
    ];
    
}
