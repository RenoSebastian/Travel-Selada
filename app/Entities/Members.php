<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $connection = 'pgsql_ardi'; // Sesuai dengan nama koneksi di .env
    protected $table = 'members'; // Nama tabel yang benar

    protected $primaryKey = 'id'; // Primary key tabel

    // Jika kolom `created_at`, `updated_at`, atau `deleted_at` tidak diperlukan
    public $timestamps = false;

    protected $fillable = [
        'id',
        'balance',
        'fullname',
        'phone',
        'email',
        'description',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'card_number',
        'opt_1',
        'opt_2',
        'opt_3',
        'opt_4',
        'opt_5',
        'is_free',
        'partner_acc_no',
        'pin_state',
        'failed_pin_trial',
        'issuer_id',
        'issuer_partner_id'
    ];

    // Menambahkan casting untuk id agar dipastikan selalu diperlakukan sebagai UUID
    protected $casts = [
        'id' => 'uuid',  // Pastikan id dicasting sebagai UUID
    ];
}
