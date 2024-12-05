<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'employId' => $this->staffId,
            'firstName' => $this->stafffirstName,
            'lastName' => $this->stafflastName,
            'birthDate' => $this->staffBirthDate,
            'gender' => $this->staffGender,
            'dni' => $this->staffDni,
            'address' => $this->staffAddress,
            'phone' => $this->staffPhone,
            'photo' => $this->staffPhoto,
            'user' => new UserResource($this->user)

        ];
    }
}
