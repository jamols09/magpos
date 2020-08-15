<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'username' => $this->username,
            'first_name' => $this->first_name, 
            'last_name' => $this->last_name, 
            'middle_name' => $this->middle_name, 
            'dob' => $this->dob, 
            'city' => $this->city, 
            'country' => $this->country, 
            'city' => $this->city, 
            'street' => $this->street, 
            'gender' => $this->gender, 
            'profile_link' => $this->profile_link, 
            'role' => $this->role, 
            'is_active'  => $this->is_active
        ];
    }
}
