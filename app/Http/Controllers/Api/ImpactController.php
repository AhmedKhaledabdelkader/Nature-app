<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImpactResource;
use Illuminate\Support\Facades\Storage;
use App\Models\Impact;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class ImpactController extends Controller
{
    

    public function store(Request $request){


   try{ 
    
    if ($request->hasFile("impactLogo")) {
            
            $logo = $request->file('impactLogo');
            $logoPath= $logo->store('impacts', 'public'); 
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

    }catch(Throwable $e){


        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while creating the impact",
            "error"=>$e->getMessage()

        ],500);




    }

     


    }








    public function index()
    {


        try{

        $impacts=Impact::all();


        return response()->json([

            "message"=>"retreiving impacts successfully",
            "impacts"=>ImpactResource::collection($impacts),



        ], 200);

    }catch(Throwable $e){

        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while retrieving the impacts",
            "error"=>$e->getMessage()

        ],500);

    }
    
    }









    public function show($impactId)
    {

        try{

        $impact = Impact::find($impactId);

        if (!$impact) {
            return response()->json(["message" => "Impact with id $impactId not found"], 404);
        }

        return response()->json([


            "message"=>"retreiving impact successfully",
            "impact"=>new ImpactResource($impact)


        ], 200);

        }catch(Throwable $e){

            return response()->json([
    
                "status"=>"error",
                "message"=>"an error occurred while retrieving the impact",
                "error"=>$e->getMessage()
    
            ],500);
    
        }
    }





    public function update(Request $request, $impactId)
    {

        try{

        $impact = Impact::find($impactId);

        if (!$impact) {
            return response()->json(["message" => "Impact with id $impactId not found"], 404);
        }

        if ($impact->impactLogo) {
            Storage::disk('public')->delete($impact->impactLogo); 
        }
        

        if ($request->hasFile("impactLogo")) {


            $logo = $request->file('impactLogo');
            $impact->impactLogo = $logo->store('impacts', 'public');
        }

        $impact->impactName = $request->impactName;
        $impact->impactNumber = $request->impactNumber;
        $impact->save();

        return response()->json([
            "message" => "Impact updated successfully",
            "impact" => $impact
        ], 200);

    }catch(Throwable $e){

        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while updating the impact",
            "error"=>$e->getMessage()

        ],500);

    }
    
    }






    public function destroy($impactId)
    {

        try{

        $impact = Impact::find($impactId);

        if (!$impact) {
            return response()->json(["message" => "Impact with id $impactId not found"], 404);
        }


        Storage::disk('public')->delete($impact->impactLogo);

        $impact->delete();

        return response()->json(["message" => "Impact deleted successfully"], 200);
        
    }catch(Throwable $e){

        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while deleting the impact",
            "error"=>$e->getMessage()

        ],500);


    }

    }



}
