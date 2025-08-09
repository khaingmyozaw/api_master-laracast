<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{

    // public static $wrap = 'tickets'; // Custimize the key
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
                'type' => 'ticket',
                'id' => $this->id,
                'attributes' => [
                    'id'    => $this->id,
                    'title' => $this->title,
                    'description' => $this->description,
                    'status' => $this->status,
                    'createdAt' => $this->created_at,
                    'updatedAt' => $this->updated_at,
                ],
                'relationships' => [
                    'author' => [
                        'data' => [
                            'type' => 'user',
                            'id'    => $this->user_id,
                            'attributes' => [
                                'id' => $this->user->id,
                                'name' => $this->user->name,
                                'email' => $this->user->email,
                            ],
                        ],
                        'links' => [
                            'self' =>'pending',
                        ],
                    ],
                ],
                'links' => [
                    'self' => route('tickets.show', ['ticket' => $this->id]),
                ],
               ];
    }
}
