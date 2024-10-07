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

    // Define the relationship to Members
    public function member()
    {
        return $this->belongsTo(Members::class, 'member_id', 'id');
    }

    // Method to handle UUID generation explicitly
    public static function boot()
    {
        parent::boot();

        // Automatically generate UUID for the id column on creation
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Str::uuid()->toString();
        });
    }
}
