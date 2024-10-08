<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Absensi extends Model
{
    protected $connection = 'pgsql_ardi'; // Database connection name
    protected $table = 'public.absensi'; // Attendance table name
    protected $primaryKey = 'id'; // Primary key for attendance table

    public $timestamps = true; // Automatically manage created_at and updated_at timestamps

    protected $fillable = [
        'id',
        'member_id', // This should match the type of ID in the members table
        'clock_in',
        'clock_out',
        'created_by',
        'updated_by',
        'deleted_at',
        'created_at',
        'updated_at',
        'delete_at',
    ];

    protected $casts = [
        'id' => 'uuid',  // Memastikan id diperlakukan sebagai UUID
        'member_id' => 'uuid', // Memastikan member_id juga diperlakukan sebagai UUID
    ];

    // Relasi ke model Members
    public function member()
    {
        return $this->belongsTo(Members::class, 'member_id', 'id');
    }
}
