<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseUserRequest extends FormRequest
{
    public function mappedAttributes(): array
    {
        $mappedAttributes = [];
        
        $attributes = [
            'data.attributes.name' => 'name',
            'data.attributes.email' => 'email',
            'data.attributes.password' => 'password',
        ];

        foreach ($attributes as $key => $attribute) {
            if ($this->has($key)) {
                $mappedAttributes[$attribute] = $this->input($key);
            }
        }

        return $mappedAttributes;
    }
}
