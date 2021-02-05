<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified' => $this->email_verified_at ? true : false,
            'time_stamps' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]

        ];
    }
}
