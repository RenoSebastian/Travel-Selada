<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model{

    protected $connection = 'pgsql_mireta'; // Koneksi ke database yang sesuai
    protected $table = 'bus'; // Nama view di PostgreSQL
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'nama_bus',
        'alamat_penjemputan',
        'tl_id',
        'tipe_bus',
        'created_at',
        'updated_at',
    ];

    // Relasi dengan model MBus
    public function mbus()
    {
        return $this->belongsTo(MBus::class, 'tipe_bus', 'id'); // tipe_bus di Bus mengacu pada id di MBus
    }

    protected $casts = [
        'tl_id' => 'uuid',  // Pastikan id dicasting sebagai UUID
    ];
}