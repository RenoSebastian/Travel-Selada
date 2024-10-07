<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $connection = 'pgsql_ardi'; // Database connection name
    protected $table = 'public.members'; // Correct table name
    protected $primaryKey = 'id'; // Primary key

    public $timestamps = false; // Set to true if you want to manage timestamps automatically

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

    // Define the relationship to Absensi
    public function absensies()
    {
        return $this->hasMany(Absensi::class, 'member_id', 'id');
    }
}
