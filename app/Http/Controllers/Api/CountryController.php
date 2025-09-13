<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

}catch(Exception $e){


    return response()->json([

        "status"=>"error",
        "message"=>"an error occurred while creating the country",
        "error"=>$e->getMessage()

    ],500);
    



}
        


    }





    public function index()
    {

    
        $countries = Country::with("projects")->get()->map(function($country) {
            return [
                "id" => $country->id,
                "countryName" => $country->countryName,
                "projects" => $country->projects->map(function($project) {
                    return [
                        "id" => $project->id,
                        "projectName" => $project->projectName,
                        "projectDescription" => $project->projectDescription,
                        "projectImage" => $project->projectImage,
                        "countryId" => $project->country_id,
                    ];
                })
            ];
        });



        return response()->json([
            "message" => "retrieving countries successfully",
            "countries"=>$countries
          
        ], 200);
    }
    



    
    public function show($countryId)
    {
        $country = Country::find($countryId);

        if (!$country) {
            return response()->json(["message" => "country with id $countryId not found"], 404);
        }

        $mappedCountry=[

 
            "id"=>$country->id,
            "countryName"=>$country->countryName




        ];

        return response()->json([


            "message"=>"retreiving country successfully",
            "country"=>$mappedCountry


        ], 200);
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
}catch(Exception $e){


    return response()->json([

        "status"=>"error",
        "message"=>"an error occurred while creating the country",
        "error"=>$e->getMessage()

    ],500);


}
  




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
