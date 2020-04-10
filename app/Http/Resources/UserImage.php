<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserImage extends JsonResource
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
            'data' => [
                'type' => $this->id,
                'user_image_id' => $this->id,
                'attirubtes' => [
                    'path' => $this->path,
                    'width' => $this->width,
                    'height' => $this->height,
                    'location' => $this->location
                ]
            ],
            'links' => [
                'self' => url('/users/' . $this->user_id)
            ]
        ];
    }
}
