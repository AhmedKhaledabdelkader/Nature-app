<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CountryController extends Controller
{
    

    public function store(Request $request){


try{

        $country=Country::create([

            "countryName"=>$request->countryName

        ]);


        return response()->json([


            "message"=>"country created successfully",
            "country"=>$country



        ],201);

}catch(Throwable $e){


    return response()->json([

        "status"=>"error",
        "message"=>"an error occurred while creating the country",
        "error"=>$e->getMessage()

    ],500);
    



}
        


    }




   public function index()
    {

    try{
    
        $countries = Country::with("projects")->get();



        return response()->json([
            "message" => "retrieving countries successfully",
            "countries"=>CountryResource::collection($countries)
          
        ], 200);


    }catch(Throwable $e){

        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while retrieving the countries",
            "error"=>$e->getMessage()

        ],500);

    }




    }




    public function show($countryId)
    {

        try{

        $country = Country::with("projects")->find($countryId);
    
        if (!$country) {
            return response()->json(["message" => "country with id $countryId not found"], 404);
        }
    
      
    
        return response()->json([
            "message" => "retrieving country successfully",
            "country" => new CountryResource($country)
        ], 200);

        }catch(Throwable $e){

            return response()->json([
    
                "status"=>"error",
                "message"=>"an error occurred while retrieving  the country",
                "error"=>$e->getMessage()
    
            ],500);
    
        }
    }
    






    public function update(Request $request,$countryId){

try{
        $country = Country::find($countryId);

        if (!$country) {
            return response()->json(["message" => "country with id $countryId not found"], 404);
        }

    
        $country->countryName=$request->countryName ;

        $country->save();


        return response()->json([

             "message"=>"country with id $countryId updated successfully",
             "country"=>$country



        ],200);
}catch(Throwable $e){


    return response()->json([

        "status"=>"error",
        "message"=>"an error occurred while updating the country",
        "error"=>$e->getMessage()

    ],500);


}
  




    }



public function destroy(Request $request,$countryId){


    try{

    $country = Country::find($countryId);

        if (!$country) {
            return response()->json(["message" => "Impact with id $countryId not found"], 404);
        }

    $country->delete();


    return response()->json([


        "message"=>"country with id $countryId deleted successfully"



    ],200);

    }catch(Throwable $e){

        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while deleting the country",
            "error"=>$e->getMessage()

        ],500);

    }



}









}
