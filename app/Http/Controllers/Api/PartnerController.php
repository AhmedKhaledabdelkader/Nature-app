<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;





class PartnerController extends Controller
{
    

    public function store(Request $request){



         App::setLocale($request->locale ?? 'en');

        if ($request->hasFile('partnerLogo')) {


        
            $logo=$request->file('partnerLogo');


            if (!$logo->isValid()) {
            
                return response()->json([

                    "status"=>"error",
                    "message"=>"partner logo is not valid"


                ]);
            }


            $logoPath= $logo->store('partners', 'private');


        }

    
        $partner = Partner::create([
    'partnerName' => [
        $request->locale => $request->partnerName ?? null, 
    ],
    'partnerLogo' => $logoPath ?? null,
]);


      return response()->json([

        "message"=>"partner created successfully",
        "partner" => new PartnerResource($partner)




      ],201);



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
    $partner = Partner::find($partnerId);

    if (!$partner) {
        return response()->json([
            "message" => "Partner with id $partnerId not found"
        ], 404);
    }

     App::setLocale($request->locale ?? 'en');

    
   $partner->setLocalizedValue('partnerName', $request->locale, $request->partnerName);

    if ($request->hasFile('partnerLogo')) {
        if ($partner->partnerLogo && Storage::disk('private')->exists($partner->partnerLogo)) {
            Storage::disk('private')->delete($partner->partnerLogo);
        }

        $logo = $request->file('partnerLogo');
        $logoPath = $logo->store('partners', 'private');
        $partner->partnerLogo = $logoPath;
    }

    $partner->save();

    return response()->json([
        "message" => "Partner updated successfully", 
        "partner" => new PartnerResource($partner)
    ], 200);
}





    public function destroy($partnerId)
    {


        $partner = Partner::find($partnerId);

        if (!$partner) {
            return response()->json(["message" => "partner with id $partnerId not found"], 404);
        }


        if ($partner->partnerLogo) {
        Storage::disk('private')->delete($partner->partnerLogo);
        }

        $partner->delete();

        return response()->json(["message" => "partner deleted successfully"], 200);

   



    }




}
