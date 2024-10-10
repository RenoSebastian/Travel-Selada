<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class MBus extends Model{

    protected $connection = 'pgsql_mireta'; // Koneksi ke database yang sesuai
    protected $table = 'm_bus'; // Nama view di PostgreSQL
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'kapasitas_bus',
    ];
}