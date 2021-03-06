<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'user_id' => $this->user_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'time_stamps' => [
                'assigned_on' => $this->assigned_on,
                'closed_on' => $this->closed_on,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]

        ];
    }
}
