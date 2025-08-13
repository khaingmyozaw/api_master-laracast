<?php

namespace App\Http\Filters\V1;

class UserFilter extends QueryFilter
{
    protected $sortable = [
        'id',
        'name',
        'email',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function name(string $value)
    {
        return $this->builder->where('name', 'LIKE', str_replace('*', '%', $value));
    }

    public function email(string $value)
    {
        return $this->builder->where('email', 'LIKE', str_replace('*', '%', $value));
    }
}
