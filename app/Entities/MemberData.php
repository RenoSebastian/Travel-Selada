<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class MemberData extends Model
{
    protected $connection = 'pgsql_ardi'; // Koneksi ke database yang sesuai
    protected $table = 'member_data'; // Nama view di PostgreSQL
    protected $primaryKey = 'id';
    public $timestamps = false; // View tidak memiliki kolom timestamps

    protected $fillable = [
        'id',
        'name',
        'code',
        'clock_in',
        'clock_out',
        'fullname',
        'member_id',
        'location_id',
        'phone',
        'created_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'sequence',
        'attendance',
    ];
}
