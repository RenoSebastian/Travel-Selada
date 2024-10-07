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
        'change_password',
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
    
    protected $casts = [
        'id' => 'uuid',  // Pastikan id dicasting sebagai UUID
    ];
    
    public function hasFullAccess()
    {
        $fullAccessRoleId = 'kantin_rsij_1';
        return $this->username === $fullAccessRoleId;
    }

    public static function attemptLogin($username, $password)
    {
        $user = User::where('username', $username)->first();
        \Log::info('User retrieval attempt:', ['username' => $username]);

        if ($user) {
            \Log::info('User found:', ['user_id' => $user->id]);
            if (Hash::check($password, $user->password)) {
                \Log::info('Password matched for user:', ['user_id' => $user->id]);
                return $user;
            } else {
                \Log::warning('Password mismatch for user:', ['username' => $username]);
            }
        } else {
            \Log::warning('User not found:', ['username' => $username]);
        }

        return null;
    }
    public function locations()
    {
        return $this->hasMany(UserLocation::class, 'user_id', 'id');
    }
}
