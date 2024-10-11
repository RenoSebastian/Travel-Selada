<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    // Tentukan tabel yang terkait jika nama tabel tidak mengikuti konvensi Laravel
    protected $table = 'roles';
    protected $connection = 'pgsql_mireta'; // Koneksi ke database yang sesuai
    protected $primaryKey = 'id';

    // Tentukan atribut yang dapat diisi massal
    protected $fillable = [
        'name', // nama role
    ];

    // Jika kamu ingin menonaktifkan timestamps otomatis (created_at dan updated_at)
    public $timestamps = true; // ini sudah default, bisa dihilangkan jika tidak diubah

    // Kamu juga bisa menambahkan metode relasi jika diperlukan
}
