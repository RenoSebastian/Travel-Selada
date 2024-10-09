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
    protected $table = 'users';
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
        // Define the usernames that have full access
        $fullAccessUsernames = ['kantin_rsij_1', 'admin2']; // Adjust this list as necessary

        return in_array($this->username, $fullAccessUsernames);
    }
    
     public static function attemptLogin($username, $password)
    {
        // Retrieve the user based on username
        $user = static::where('username', $username)->first();

        // Check if user exists and if the password matches
        if ($user && Hash::check($password, $user->password)) {
            return $user; // Return the user object if credentials are correct
        }

        return null; // Return null if authentication fails
    }

    public function locations()
    {
        return $this->hasMany(UserLocation::class, 'user_id', 'id');
    }
}
