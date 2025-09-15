<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    

    public function store(Request $request){


    try{ 

        if ($request->hasFile('partnerLogo')) {
        
            $logo=$request->file('partnerLogo');


            $logoPath= $logo->store('partners', 'public');


        }

      $partner=Partner::create([


        "partnerName"=>$request->partnerName??null,
        "partnerLogo"=>$logoPath??null




      ]);


      return response()->json([

        "message"=>"partner created successfully",
        "partner"=>$partner




      ],201);




    }catch(Exception $e){


        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while creating the partner",
            "error"=>$e->getMessage()

        ],500);




    }





    }


    public function index(Request $request){



$partners=Partner::all();


return response()->json([


    "message"=>"partners retrieved successfully",
    "partners"=>PartnerResource::collection($partners)


],200);




    }



    public function show($partnerId)
    {
        $partner = Partner::find($partnerId);

        if (!$partner) {
            return response()->json(["message" => "partner with id $partnerId not found"], 404);
        }


        return response()->json([


            "message"=>"retreiving partner successfully",
            "partner"=>new PartnerResource($partner)


        ], 200);
    }




    public function update(Request $request, $partnerId)
    {

        try{

        $partner = Partner::find($partnerId);

        if (!$partner) {
            return response()->json(["message" => "partner with id $partnerId not found"], 404);
        }

        if ($partner->partnerLogo) {
            Storage::disk('public')->delete($partner->partnerLogo); 
        }
        

        if ($request->hasFile("partnerLogo")) {


            $logo = $request->file('partnerLogo');
            $logoPath = $logo->store('partners', 'public');
        }

        $partner->partnerLogo=$logoPath??null ;

        $partner->partnerName = $request->partnerName??null;
        $partner->save();

        return response()->json([
            "message" => "partner updated successfully",
            "partner" => $partner
        ], 200);}catch(\Throwable  $e){


            return response()->json([
    
                "status"=>"error",
                "message"=>"an error occurred while updating the partner",
                "error"=>$e->getMessage()
    
            ],500);
    
    
    
    
        }
    }




    public function destroy($partnerId)
    {
        $partner = Partner::find($partnerId);

        if (!$partner) {
            return response()->json(["message" => "partner with id $partnerId not found"], 404);
        }


        if ($partner->partnerLogo) {
        Storage::disk('public')->delete($partner->partnerLogo);
        }

        $partner->delete();

        return response()->json(["message" => "partner deleted successfully"], 200);
    }








}
