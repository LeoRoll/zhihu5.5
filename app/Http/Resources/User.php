<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class User extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    public function with($request)
    {
        return [
            'code' => 1,
            'status' => 'success'
        ];
    }

    public function posts()
    {

    }
}
