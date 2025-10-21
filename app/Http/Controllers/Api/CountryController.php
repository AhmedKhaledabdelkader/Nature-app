<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CountryController extends Controller
{
    

    public function store(Request $request){

    App::setLocale($request->locale ?? 'en');


        $country=Country::create([

            "countryName"=>[ $request->locale => $request->countryName ?? null,],

        ]);


        return response()->json([


            "message"=>"country created successfully",
            "country"=>new CountryResource($country)



        ],201);
    


    }




   public function index()
    {

   
    
        $countries = Country::with("projects")->get();



        return response()->json([
            "message" => "retrieving countries successfully",
            "countries"=>CountryResource::collection($countries)
          
        ], 200);



    }




    public function show($countryId)
    {

       

        $country = Country::with("projects")->find($countryId);
    
        if (!$country) {
            return response()->json(["message" => "country with id $countryId not found"], 404);
        }
    
      
    
        return response()->json([
            "message" => "retrieving country successfully",
            "country" => new CountryResource($country)
        ], 200);

 
    }
    






    public function update(Request $request,$countryId){


        $country = Country::find($countryId);

        if (!$country) {
            return response()->json(["message" => "country with id $countryId not found"], 404);
        }

        App::setLocale($request->locale ?? 'en');
    
        $country->setLocalizedValue('countryName', $request->locale, $request->countryName);

        $country->save();


        return response()->json([

             "message"=>"country with id $countryId updated successfully",
             "country"=>new CountryResource($country)



        ],200);



}
  




    



public function destroy(Request $request,$countryId){


   

    $country = Country::find($countryId);

        if (!$country) {
            return response()->json(["message" => "Impact with id $countryId not found"], 404);
        }

    $country->delete();


    return response()->json([


        "message"=>"country with id $countryId deleted successfully"



    ],200);

    }

}














