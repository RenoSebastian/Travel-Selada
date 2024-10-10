<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserLocation extends Model
{
    protected $connection = 'pgsql_mireta';
    protected $table = 'user_locations';
    protected $primaryKey = 'id'; // Ini adalah auto-increment, tidak perlu didefinisikan
    public $timestamps = true; // Jika Anda ingin timestamps otomatis, ubah ke true

    protected $fillable = [
        'user_id',
        'brand_id',
        'location_id',
        // 'created_at', // tidak perlu karena akan otomatis diisi jika $timestamps true
        // 'updated_at', // tidak perlu karena akan otomatis diisi jika $timestamps true
    ];

    public function location()
    {
        return $this->belongsTo(MLocation::class, 'location_id', 'id');
    }
}
