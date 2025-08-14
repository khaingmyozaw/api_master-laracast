<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseTicketRequest extends FormRequest
{

    public function mappedAttributes(): array
    {
        $mappedAttributes = [];
        
        $attributes = [
            'data.attributes.title' => 'title',
            'data.attributes.status' => 'status',
            'data.attributes.description' => 'description',
            'data.attributes.createdAt' => 'created_at',
            'data.attributes.updatedAt' => 'updated_at',
            'data.relationships.author.data.id' => 'user_id',
        ];

        foreach ($attributes as $key => $attribute) {
            if ($this->has($key)) {
                $mappedAttributes[$attribute] = $this->input($key);
            }
        }

        return $mappedAttributes;
    }

    public function  messages(): array
    {
        return [
            'data.attributes.status' => 'Ticket status should one of A,C,H and X',
            'data.relationships.author.data.id' => 'The select user cannot be found',
        ];
    }
}
