<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Members extends Model
{
    protected $connection = 'pgsql_ardi';
    protected $table = 'public.members';
    protected $primaryKey = 'id';
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
        'issuer_partner_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function absensies()
    {
        return $this->hasMany(Absensi::class, 'member_id', 'id');
    }
}

