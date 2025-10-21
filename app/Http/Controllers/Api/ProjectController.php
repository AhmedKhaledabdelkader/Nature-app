<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Exception ;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProjectController extends Controller
{
    

    public function store(Request $request){



        $imagePath=null;

         App::setLocale($request->locale ?? 'en');

        if ($request->hasFile("projectImage")) {
        
            $image= $request->file('projectImage');
            $imagePath= $image->store('projects', 'private');             

        }


        $project=Project::create([


            "projectName"=> [$request->locale => $request->projectName ?? null, ],
            "projectDescription"=>[$request->locale => $request->projectDescription ?? null, ],
            "projectImage"=>$imagePath,
            "country_id"=>$request->country_id

        ]);


        return response()->json([


            "message"=>"project created successfully",
            "project"=>new ProjectResource($project)



        ],201);

   
    }




    public function index()
    {

        

        $projects=Project::all();

        
        return response()->json([

            "message"=>"retreiving projects successfully",
            "projects"=>ProjectResource::collection($projects)



        ], 200);

  

}



    public function show($id)
    {
        
            $project = Project::find($id);
            
            if (!$project) {
                return response()->json([
                    "status" => "error",
                    "message" => "Project not found"
                ], 404);
            }
        
    


            return response()->json([
                "message" => "Project retrieved successfully",
                "project" => new ProjectResource($project)
            ], 200);
            
       
    }


public function update(Request $request, $projectId)
{
  
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json([
                "message" => "Project with id $projectId not found"
            ], 404);
        }

         App::setLocale($request->locale ?? 'en');


       $project->setLocalizedValue('projectName', $request->locale, $request->projectName);
       $project->setLocalizedValue('projectDescription', $request->locale, $request->projectDescription);
       $project->country_id = $request->country_id ?? $project->country_id;

      
        if ($request->hasFile('projectImage')) {

       
            if ($project->projectImage && Storage::disk('private')->exists($project->projectImage)) {
                Storage::disk('private')->delete($project->projectImage);
            }

            $image = $request->file('projectImage');
            $imagePath = $image->store('projects', 'private');
            $project->projectImage = $imagePath;
        }

      
        $project->save();

        return response()->json([
            "message" => "Project updated successfully",
            "project" => new ProjectResource($project)
        ], 200);


}







    public function destroy(Request $request,$projectId){


        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(["message" => "project with id $projectId not found"], 404);
        }


        Storage::disk('private')->delete($project->projectImage);

        $project->delete();

        return response()->json(["message" => "project deleted successfully"], 200);


    
    }




    }

    





 



