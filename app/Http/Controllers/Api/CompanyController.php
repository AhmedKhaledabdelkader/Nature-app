<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\App;
use Throwable;

class CompanyController extends Controller
{


    public function store(Request $request){




    $videoPath=null;
    $logoPath=null;


    App::setLocale($request->locale ?? 'en');


        if ($request->hasFile('company_image')) {
          
            $video = $request->file('company_image');
            $videoPath= $video->store('companies/videos', 'private'); 
        }


        if ($request->hasFile('company_logo')) {
          
            $logo = $request->file('company_logo');
            $logoPath= $logo->store('companies/logos', 'private'); 
        }


        $company=Company::create([


            "company_name"=>[ $request->locale => $request->company_name ?? null,],
            "company_description"=>[ $request->locale => $request->company_description?? null,],
            "company_image"=>$videoPath,
            "company_logo"=>$logoPath??null

        ]);


        return response()->json([

            "message"=>"company created successfully",
             "company"=>new CompanyResource($company)
            


        ],201);

   

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


public function update(Request $request, $companyId)
{
   
        $company = Company::find($companyId);

        if (!$company) {
            return response()->json([
                "message" => "Company with id $companyId not found"
            ], 404);
        }

         App::setLocale($request->locale ?? 'en');

     
        $company->setLocalizedValue('company_name', $request->locale, $request->company_name);
        $company->setLocalizedValue('company_description', $request->locale, $request->company_description);

    
        if ($request->hasFile('company_image')) {
            // delete old image if exists
            if ($company->company_image && Storage::disk('private')->exists($company->company_image)) {
                Storage::disk('private')->delete($company->company_image);
            }

         
            $image = $request->file('company_image');
            $imagePath = $image->store('companies/videos', 'private');
            $company->company_image = $imagePath;
        }

        // ✅ Update company_logo ONLY if a new logo is uploaded
        if ($request->hasFile('company_logo')) {
            // delete old logo if exists
            if ($company->company_logo && Storage::disk('private')->exists($company->company_logo)) {
                Storage::disk('private')->delete($company->company_logo);
            }

            // store new logo
            $logo = $request->file('company_logo');
            $logoPath = $logo->store('companies/logos', 'private');
            $company->company_logo = $logoPath;
        }

        // ✅ Save updates
        $company->save();

        return response()->json([
            "message" => "Company updated successfully",
            "company" => new CompanyResource($company)
        ], 200);

   
}






public function destroy(Request $request,$companyId){

   

    $company=Company::where("id",$companyId)->first();


    if (!$company) {
        
        return response()->json([
       
            "message"=>"company with id $companyId not found"
        


        ],404);
    }



       if ($company->company_image) {
        
   
        Storage::disk('private')->delete($company->company_image);

       }


        if ($company->company_logo) {
            
            Storage::disk('private')->delete($company->company_logo);
        }
    

    $company->delete();


    return response()->json([

        "message"=>"company with id $companyId deleted successfully"

    ],200);

   



}







}


















