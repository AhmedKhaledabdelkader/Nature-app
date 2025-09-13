<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Exception ;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    

    public function store(Request $request){

try{

        $imagePath=null;

        if ($request->hasFile("projectImage")) {
        
            $image= $request->file('projectImage');
            $imagePath= $image->store('projects', 'public');             

        }


        $project=Project::create([


            "projectName"=>$request->projectName,
            "projectDescription"=>$request->projectDescription,
            "projectImage"=>$imagePath,
            "country_id"=>$request->country_id

        ]);


        return response()->json([


            "message"=>"project created successfully",
            "project"=>$project



        ],201);

    }catch(Exception $e){


        return response()->json([
    
            "status"=>"error",
            "message"=>"an error occurred while creating the project",
            "error"=>$e->getMessage()
    
        ],500);
        


    }
    }




    public function index()
    {


        $projects=Project::all()->map(function($project){

        return [


            "id"=>$project->id,
            "projectName"=>$project->projectName,
            "projectDescription"=>$project->projectDescription,
            "projectImage"=>$project->projectImage,
            "countryId"=>$project->country_id



        ];




        });

        
        return response()->json([

            "message"=>"retreiving projects successfully",
            "countries"=>$projects



        ], 200);
    }



    public function show($id)
    {
        try {
            $project = Project::find($id);
            
            if (!$project) {
                return response()->json([
                    "status" => "error",
                    "message" => "Project not found"
                ], 404);
            }
        
    
            $mappedProject=[
                "id" => $project->id,
                "projectName" => $project->projectName,
                "projectDescription" => $project->projectDescription,
                "projectImage" => $project->projectImage,
                "countryId" => $project->country_id
            ];


            return response()->json([
                "message" => "Project retrieved successfully",
                "project" => $mappedProject
            ], 200);
            
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "An error occurred while retrieving the project",
                "error" => $e->getMessage()
            ], 500);
        }
    }





    public function update(Request $request,$projectId){

        try{
    
        $project=Project::where("id",$projectId)->first();
    
    
        if (!$project) {
            
            return response()->json([
           
                "message"=>"project with id $projectId not found"
            
    
    
            ],404);
        }
    
        $project->projectName=$request->projectName;
        $project->projectDescription=$request->projectDescription;
        $project->country_id=$request->country_id;
    
        
    
            if ($project->projectImage) {
                Storage::disk('public')->delete($project->projectImage); 
            }
    
    
            $image = $request->file('projectImage');
            $imagePath= $image->store('projects', 'public'); 
           
            $project->projectImage=$imagePath;
        
        
        
            
    
    
            $project->save();
    
        
    
    
            return response()->json([
                "message" => "project updated successfully",
                "project" => $project
            ], 200);
    
        }catch (Exception $e) {
            
            return response()->json([
    
                "status"=>"error",
                "message"=>"an error occurred while updating the project",
                "error"=>$e->getMessage()
    
            ],500);
    
        }
    
    
    
    }




    public function destroy(Request $request,$projectId){


        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(["message" => "project with id $projectId not found"], 404);
        }


        Storage::disk('public')->delete($project->projectImage);

        $project->delete();

        return response()->json(["message" => "project deleted successfully"], 200);
    }








    }

    





 



