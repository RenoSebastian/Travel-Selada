<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable; // Import trait

class User extends Model implements AuthenticatableContract
{
    use Authenticatable; // Gunakan trait Authenticatable

    protected $connection = 'pgsql_mireta';
    protected $table = 'public.users';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'fullname',
        'username',
        'email',
        'password',
        'is_active',
        'is_block',
        'is_pristine',
        'change_pssword',
        'last_login',
        'remember_token',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'ref_ardi',
        'version',
        'role_id',
        'group_id'
    ];

    public function hasFullAccess()
    {
        $fullAccessRoleId = 'kantin_rsij_1';
        return $this->username === $fullAccessRoleId;
    }

    public static function attemptLogin($username, $password)
    {
        $user = User::where('username', $username)->first();
        \Log::info('User retrieved:', ['user' => $user]);
    
        if ($user && Hash::check($password, $user->password)) {
            \Auth::login($user);
            return $user;
        }
        
        return null;
    }
    
}
