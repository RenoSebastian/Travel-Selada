<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable, HasUuids;

    protected $connection = 'pgsql_mireta';
    protected $table = 'user_travel';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'fullname',
        'username',
        'password',
        'email',
        'phone',
        'role_id',
        'created_at',
        'updated_at',
        'id_bus'
    ];
    
    protected $casts = [
        'id' => 'uuid',
    ];
    
     public static function attemptLogin($username, $password)
    {
        $user = static::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        return null; 
    }

    public function locations()
    {
        return $this->hasMany(UserLocation::class, 'user_id', 'id');
    }
}
