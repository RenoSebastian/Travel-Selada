<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PesertaTour extends Model
{
    protected $table = 'peserta_tour'; 
    protected $connection = 'pgsql_ardi';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'fullname',
        'phone_number',
        'card_number',
        'bus_location',
        'status',
        'seat',
        'id_user',
        'class',         
        'clock_in',     
        'clock_out'     
    ];

    public $timestamps = true;

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
    
}
