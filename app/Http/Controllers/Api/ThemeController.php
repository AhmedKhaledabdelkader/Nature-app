<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ThemeResource;
use App\Models\Theme;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;


use Exception ;
use Throwable;

class ThemeController extends Controller
{




    public function store(Request $request)
    {
        try {
            $imagePath = null;
            
            if ($request->hasFile("themeImage")) {
                $image = $request->file('themeImage');
                $imagePath = $image->store('themes', 'private');
            }

            $theme = Theme::create([
                "themeName" => $request->themeName,
                "themeDescription" => $request->themeDescription,
                "themeImage" => $imagePath
            ]);

            return response()->json([
                "message" => "theme created successfully",
                "theme" => $theme
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                "status" => "error",
                "message" => "an error occurred while creating the theme",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {

    try{

        $themes = Theme::all();

        return response()->json([
            "message" => "retreiving themes successfully",
            "themes" => ThemeResource::collection($themes)
    
        ], 200);

    }catch(Throwable $e){

        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while retrieving themes",
            "error"=>$e->getMessage()

        ],500);
    
    }

    }

    public function show($themeId)
    {

        try{

        $theme = Theme::find($themeId);

        if (!$theme) {
            return response()->json(["message" => "Theme with id $themeId not found"], 404);
        }


        return response()->json([
            "message" => "retreiving theme successfully",
            "theme" => new ThemeResource($theme),
        ], 200);
    }catch(Throwable $e){

        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while retrieving theme",
            "error"=>$e->getMessage()

        ],500);
    }


    }



public function update(Request $request, $themeId)
{
    try {
        $theme = Theme::find($themeId);

        if (!$theme) {
            return response()->json([
                "message" => "Theme with id $themeId not found"
            ], 404);
        }

        // ✅ Update basic fields
        $theme->themeName = $request->themeName ?? $theme->themeName;
        $theme->themeDescription = $request->themeDescription ?? $theme->themeDescription;

        // ✅ Only update image if a new one is uploaded
        if ($request->hasFile('themeImage')) {

            // Delete old image if exists
            if ($theme->themeImage && Storage::disk('private')->exists($theme->themeImage)) {
                Storage::disk('private')->delete($theme->themeImage);
            }

            // Store new image
            $image = $request->file('themeImage');
            $imagePath = $image->store('themes', 'private');
            $theme->themeImage = $imagePath;
        }

        // ✅ Save updates
        $theme->save();

        return response()->json([
            "message" => "Theme updated successfully",
            "theme" => $theme
        ], 200);

    } catch (\Throwable $e) {
        return response()->json([
            "status" => "error",
            "message" => "An error occurred while updating the theme",
            "error" => $e->getMessage()
        ], 500);
    }
}





    public function destroy($themeId)
    {

        try{

        $theme = Theme::find($themeId);

        if (!$theme) {
            return response()->json(["message" => "Theme with id $themeId not found"], 404);
        }

        if ($theme->themeImage) {
            Storage::disk('private')->delete($theme->themeImage);
        }

        $theme->delete();

        return response()->json(["message" => "Theme deleted successfully"], 200);
    }catch(Throwable $e){

        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while deleting theme",
            "error"=>$e->getMessage()

        ],500);

    }
}
}
    












