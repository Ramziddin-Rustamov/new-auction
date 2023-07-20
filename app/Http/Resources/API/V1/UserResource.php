<?php

namespace App\Http\Resources\API\v1;

use App\Http\Resources\API\V1\BiddingHistoryResource;
use App\Http\Resources\API\V1\CurrentBidResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'fullname' => $this->fullname,
            'username'=>$this->username,
            'email'=>$this->email,
            'email_verified_at' =>$this->email_verified_at,
            'created_at' =>$this->created_at,
            'updated_at'=>$this->updated_at,
            'myCurrentBid' =>CurrentBidAuthResource::collection($this->myCurrentBid),
            'myBidHistory' =>BidHistoryAuthResource::collection($this->myBidHistory)
        ];
    }
}
