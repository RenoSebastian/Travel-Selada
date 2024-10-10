<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class MLocation extends Model
{

    protected $connection = 'pgsql_mireta';
    protected $table = 'm_locations';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'business_id',
        'brand_id',
        'name',
        'address',
        'email',
        'phone',
        'add_stock_allowed',
        'point_of_sale_allowed',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public function brand()
    {
        return $this->belongsTo(MBrand::class, 'brand_id', 'id');
    }
}
