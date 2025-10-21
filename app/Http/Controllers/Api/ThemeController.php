<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ThemeResource;
use App\Models\Theme;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;


use Exception ;
use Illuminate\Support\Facades\App;
use Throwable;

class ThemeController extends Controller
{




    public function store(Request $request)
    {
       
            $imagePath = null;

        App::setLocale($request->locale ?? 'en');

            
            if ($request->hasFile("themeImage")) {
                $image = $request->file('themeImage');
                $imagePath = $image->store('themes', 'private');
            }

            $theme = Theme::create([
                "themeName" => [ $request->locale => $request->themeName ?? null,],
                "themeDescription" =>[ $request->locale => $request->themeDescription ?? null,],
                "themeImage" => $imagePath??null
            ]);

            return response()->json([
                "message" => "theme created successfully",
                "theme" => new ThemeResource($theme)
            ], 201);
        } 

    public function index()
    {


        $themes = Theme::all();

        return response()->json([
            "message" => "retreiving themes successfully",
            "themes" => ThemeResource::collection($themes)
    
        ], 200);

    }

    public function show($themeId){
    

        $theme = Theme::find($themeId);

        if (!$theme) {
            return response()->json(["message" => "Theme with id $themeId not found"], 404);
        }


        return response()->json([
            "message" => "retreiving theme successfully",
            "theme" => new ThemeResource($theme),
        ], 200);
    

    }



public function update(Request $request, $themeId){

        $theme = Theme::find($themeId);

        if (!$theme) {
            return response()->json([
                "message" => "Theme with id $themeId not found"
            ], 404);
        }

         App::setLocale($request->locale ?? 'en');
        
         $theme->setLocalizedValue('themeName', $request->locale, $request->themeName);
         $theme->setLocalizedValue('themeDescription', $request->locale, $request->themeDescription);

      
        if ($request->hasFile('themeImage')) {

       
            if ($theme->themeImage && Storage::disk('private')->exists($theme->themeImage)) {
                Storage::disk('private')->delete($theme->themeImage);
            }

            
            $image = $request->file('themeImage');
            $imagePath = $image->store('themes', 'private');
            $theme->themeImage = $imagePath;
        }

        $theme->save();

        return response()->json([
            "message" => "Theme updated successfully",
            "theme" => new ThemeResource($theme)
        ], 200);

   
}





    public function destroy($themeId){
    

        $theme = Theme::find($themeId);

        if (!$theme) {
            return response()->json(["message" => "Theme with id $themeId not found"], 404);
        }

        if ($theme->themeImage) {
            Storage::disk('private')->delete($theme->themeImage);
        }

        $theme->delete();

        return response()->json(["message" => "Theme deleted successfully"], 200);
  
}

    


}









