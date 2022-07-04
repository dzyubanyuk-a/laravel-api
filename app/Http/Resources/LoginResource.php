<?php

namespace App\Http\Resources;

use App\Http\Requests\LoginUserRequest;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginResource extends JsonResource
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
            'id'=>$this->resource->id,
            'login'=>$this->resource->login,
            'name'=>$this->resource->name,
            'email'=>$this->resource->email,
            'image'=>$this->resource->image,
            'about'=>$this->resource->about,
            'type'=>$this->resource->type,
            'github'=>$this->resource->github,
            'city'=>$this->resource->city,
            'is_finished'=>$this->resource->is_finished,
            'phone'=>$this->resource->phone,
            'birthday'=>$this->resource->birthday,
        ];
    }
}
