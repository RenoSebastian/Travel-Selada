<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model{

    protected $connection = 'pgsql_mireta'; // Koneksi ke database yang sesuai
    protected $table = 'bus'; // Nama view di PostgreSQL
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nama_bus',
        'alamat',
        'tipe_bus',
    ];
}