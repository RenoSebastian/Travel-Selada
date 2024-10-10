<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class MBus extends Model{

    protected $connection = 'pgsql_mireta'; // Koneksi ke database yang sesuai
    protected $table = 'm_bus'; // Nama view di PostgreSQL
    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'kapasitas_bus',
        'created_at',
        'updated_at',
    ];

      // Relasi dengan model Bus
      public function buses()
      {
          return $this->hasMany(Bus::class, 'tipe_bus', 'id'); // tipe_bus di Bus mengacu pada id di MBus
      }
}