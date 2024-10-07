<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AdminScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Misalkan kita ingin hanya mengambil pengguna admin
        $builder->where('username', 'kantin_rsij_1');
    }
}
