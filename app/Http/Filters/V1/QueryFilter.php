<?php

namespace App\Http\Filters\V1;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected $builder;

    protected $request;

    protected $sortable = [];

    public function __construct(
        Request $request
    ) {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $builder;
    }

    public function createdAt(string $value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }

    protected function filter(array $arr)
    {
        foreach ($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    public function id(string $value)
    {
        return $this->builder->whereIn('id', explode(',', $value));
    }

    public function updatedAt(string $value)
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        return $this->builder->whereDate('updated_at', $value);
    }

    protected function sort(string $value)
    {
        $sortingAttributes = explode(',', $value);
        
        foreach ($sortingAttributes as $attribute) {
            $direction = 'ASC';

            if (strpos($attribute, '-') === 0) { // it is minus(-) leading values that means DESC
                $direction = 'DESC';
                $attribute = substr($attribute, 1);
            }

            if (
                !in_array($attribute, $this->sortable) &&
                !array_key_exists($attribute, $this->sortable)
            ) {
                continue;
            }

            $column = $this->sortable[$attribute] ?? null;

            

            $this->builder->orderBy($column ? $column : $attribute, $direction);
        }
    }
}
