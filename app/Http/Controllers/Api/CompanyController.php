<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;


class CompanyController extends Controller
{


    public function store(Request $request){


try{

    $videoPath=null;
    $logoPath=null;

        if ($request->hasFile('company_image')) {
          
            $video = $request->file('company_image');
            $videoPath= $video->store('companies/videos', 'public'); 
        }


        if ($request->hasFile('company_logo')) {
          
            $logo = $request->file('company_logo');
            $logoPath= $logo->store('companies/logos', 'public'); 
        }


        $company=Company::create([


            "company_name"=>$request->company_name,
            "company_description"=>$request->company_description,
            "company_image"=>$videoPath,
            "company_logo"=>$logoPath??null





        ]);


        return response()->json([

            "message"=>"company created successfully",
             "company"=>$company
            


        ],201);

    }catch(Exception $e){

        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while creating the company",
            "error"=>$e->getMessage()

        ],500);

    }



    }
    








public function index(Request $request){




    $companies = Company::all();
    return response()->json([


        "message"=>"companies retrieved successfully",
        "companies"=>CompanyResource::collection($companies),

    ],200);

}







public function show(Request $request,$companyId){


    $company=Company::where("id",$companyId)->first();


    if (!$company) {
        
        return response()->json([
       
            "message"=>"company with id $companyId not found"
        


        ],404);
    }



    return response()->json([

        "message"=>"company retrieved successfully",
        "company"=>new CompanyResource($company)



    ],200);



}


public function update(Request $request,$companyId){

    try{

    $company=Company::where("id",$companyId)->first();


    if (!$company) {
        
        return response()->json([
       
            "message"=>"company with id $companyId not found"
        


        ],404);
    }

    $company->company_name=$request->company_name;
    $company->company_description=$request->company_description;

    

        if ($company->company_image) {
            Storage::disk('public')->delete($company->company_image); 
        }


        $video = $request->file('company_image');
        $videoPath= $video->store('companies/videos', 'public'); 
       
        $company->company_image= $videoPath;
    
    
    
        if ($request->hasFile('company_logo')) {


            
        if ($company->company_logo) {
            Storage::disk('public')->delete($company->company_logo); 
        }


            $logo = $request->file('company_logo');
            $logoPath = $logo->store('companies/logos', 'public');
            $company->company_logo = $logoPath;
        }


        $company->save();

    


        return response()->json([
            "message" => "Company updated successfully",
            "company" => $company
        ], 200);

    }catch (Exception $e) {
        
        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while creating the company",
            "error"=>$e->getMessage()

        ],500);

    }



}


public function destroy(Request $request,$companyId){

    $company=Company::where("id",$companyId)->first();


    if (!$company) {
        
        return response()->json([
       
            "message"=>"company with id $companyId not found"
        


        ],404);
    }



       if ($company->company_image) {
        
   
        Storage::disk('public')->delete($company->company_image);

       }


        if ($company->company_logo) {
            
            Storage::disk('public')->delete($company->company_logo);
        }
    

    $company->delete();


    return response()->json([

        "message"=>"company with id $companyId deleted successfully"

    ],200);





}







}


















