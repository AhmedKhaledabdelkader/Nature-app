<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
    return [

        "id"=>$this->id,
        "partnerName"=>$this->partnerName,
        "partnerLogo"=>$this->partnerLogo,     
        'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
        'updatedAt' => $this->updated_at->format('Y-m-d H:i:s')





    ];
    }
}
