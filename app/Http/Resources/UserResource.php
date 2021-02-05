<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            ],
<<<<<<< HEAD
            'role' => new RoleResource($this->role),
=======
>>>>>>> 8f9de2fcbc92b00e54b8f91ce7318c52e5b542f0
            'tasks' => TaskResource::collection($this->tasks)
        ];
    }
}
