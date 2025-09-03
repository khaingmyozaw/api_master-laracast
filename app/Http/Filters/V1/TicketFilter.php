<?php

namespace App\Http\Filters\V1;

class TicketFilter extends QueryFilter
{
    protected $sortable = [
        'id',
        'title',
        'status',
        'description',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function included(string|array $value)
    {
        return $this->builder->with($value);
    }

    public function status(string $value)
    {
        return $this->builder->whereIn('status', explode(',', $value));
    }

    public function title(string $value)
    {
        return $this->builder->where('title', 'LIKE', str_replace('*', '%', $value));
    }

}
