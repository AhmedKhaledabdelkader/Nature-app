<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 

        [

            "id" => $this->id,
            "companyName"=>$this->company_name,
            "companyDescription"=>$this->company_description,
            "companyImage"=>$this->company_image,
            "companyLogo"=>$this->company_logo,
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at->format('Y-m-d H:i:s')

        ];
    }
}
