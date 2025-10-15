<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Exception ;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProjectController extends Controller
{
    

    public function store(Request $request){



        $imagePath=null;

        if ($request->hasFile("projectImage")) {
        
            $image= $request->file('projectImage');
            $imagePath= $image->store('projects', 'private');             

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

        // ✅ Update basic fields
        $project->projectName = $request->projectName ?? $project->projectName;
        $project->projectDescription = $request->projectDescription ?? $project->projectDescription;
        $project->country_id = $request->country_id ?? $project->country_id;

        // ✅ Only update the image if a new file is uploaded
        if ($request->hasFile('projectImage')) {

            // Delete old image if exists
            if ($project->projectImage && Storage::disk('private')->exists($project->projectImage)) {
                Storage::disk('private')->delete($project->projectImage);
            }

            // Store new image
            $image = $request->file('projectImage');
            $imagePath = $image->store('projects', 'private');
            $project->projectImage = $imagePath;
        }

        // ✅ Save updates
        $project->save();

        return response()->json([
            "message" => "Project updated successfully",
            "project" => $project
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

    





 



