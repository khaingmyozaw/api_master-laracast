<?php

namespace App\Http\Filters\V1;

class TicketFilter extends QueryFilter
{
    public function createdAt(string $value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }

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

    public function updatedAt(string $value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        return $this->builder->whereDate('updated_at', $value);
    }
}
