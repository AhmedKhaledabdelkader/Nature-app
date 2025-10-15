<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImpactResource;
use Illuminate\Support\Facades\Storage;
use App\Models\Impact;
use Exception;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Log; 

class ImpactController extends Controller
{
    

    public function store(Request $request){


  
    if ($request->hasFile("impactLogo")) {
            
            $logo = $request->file('impactLogo');
            $logoPath= $logo->store('impacts', 'private'); 
        }


        $impact=Impact::create([


            "impactName"=>$request->impactName,
            "impactNumber"=>$request->impactNumber,
            "impactLogo"=>$logoPath



        ]);



        return response()->json([


            "message"=>"impact created successfully",
            "impact"=>$impact



        ],201);

   

     


    }








    public function index()
    {


     

        $impacts=Impact::all();


        return response()->json([

            "message"=>"retreiving impacts successfully",
            "impacts"=>ImpactResource::collection($impacts),



        ], 200);

   
    
    }









    public function show($impactId)
    {

        

        $impact = Impact::find($impactId);

        if (!$impact) {
            return response()->json(["message" => "Impact with id $impactId not found"], 404);
        }

        return response()->json([


            "message"=>"retreiving impact successfully",
            "impact"=>new ImpactResource($impact)


        ], 200);

        
    }





   public function update(Request $request, $impactId)
{
    
        $impact = Impact::find($impactId);

        if (!$impact) {
            return response()->json(["message" => "Impact with id $impactId not found"], 404);
        }


        $impact->impactName = $request->impactName;
        $impact->impactNumber = $request->impactNumber;

 
        if ($request->hasFile('impactLogo')) {

           
            if ($impact->impactLogo && Storage::disk('private')->exists($impact->impactLogo)) {
                Storage::disk('private')->delete($impact->impactLogo);
            }

            $logo = $request->file('impactLogo');
            $impact->impactLogo = $logo->store('impacts', 'private');
        }

       
        $impact->save();

        return response()->json(["message" => "Impact updated successfully", "impact" => $impact], 200);

   
}







    public function destroy($impactId)
    {

        

        $impact = Impact::find($impactId);

        if (!$impact) {
            return response()->json(["message" => "Impact with id $impactId not found"], 404);
        }


        Storage::disk('private')->delete($impact->impactLogo);

        $impact->delete();

        return response()->json(["message" => "Impact deleted successfully"], 200);
        
    

    }

  


 

}




