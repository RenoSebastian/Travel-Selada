<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $connection = 'pgsql_ardi'; // Sesuai dengan nama koneksi di .env
    protected $table = 'public.absensi'; // Nama tabel absensi

    protected $primaryKey = 'id'; // Primary key tabel

    public $timestamps = true; // Otomatis menangani created_at dan updated_at

    protected $fillable = [
        'member_id',
        'clock_in',
        'clock_out',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at',
        'delete_at',
    ];
}
