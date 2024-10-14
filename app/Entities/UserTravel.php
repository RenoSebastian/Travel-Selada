<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class UserTravel extends Model{

    protected $connection = 'pgsql_mireta'; // Koneksi ke database yang sesuai
    protected $table = 'user_travel'; // Nama view di PostgreSQL
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
        'id_bus',
    ];

    // Menambahkan casting untuk id agar dipastikan selalu diperlakukan sebagai UUID
    protected $casts = [
        'id' => 'uuid',  // Pastikan id dicasting sebagai UUID
    ];

    public function buses()
    {
        return $this->belongsTo(Bus::class, 'id_bus', 'id'); // id_bus di UserTravel mengacu pada id di Bus
    }
}