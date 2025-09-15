<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ThemeResource;
use App\Models\Theme;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;


use Exception ;

class ThemeController extends Controller
{




    public function store(Request $request)
    {
        try {
            $imagePath = null;
            
            if ($request->hasFile("themeImage")) {
                $image = $request->file('themeImage');
                $imagePath = $image->store('themes', 'public');
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
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "an error occurred while creating the theme",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $themes = Theme::all();

        return response()->json([
            "message" => "retreiving themes successfully",
            "themes" => ThemeResource::collection($themes)
        ], 200);
    }

    public function show($themeId)
    {
        $theme = Theme::find($themeId);

        if (!$theme) {
            return response()->json(["message" => "Theme with id $themeId not found"], 404);
        }


        return response()->json([
            "message" => "retreiving theme successfully",
            "theme" => new ThemeResource($theme),
        ], 200);
    }

    public function update(Request $request, $themeId)
    {
        $theme = Theme::find($themeId);

        if (!$theme) {
            return response()->json(["message" => "Theme with id $themeId not found"], 404);
        }

        if ($theme->themeImage) {
            Storage::disk('public')->delete($theme->themeImage);
        }

        if ($request->hasFile("themeImage")) {
            $image = $request->file('themeImage');
            $theme->themeImage = $image->store('themes', 'public');
        }

        $theme->themeName = $request->themeName;
        $theme->themeDescription = $request->themeDescription;
        $theme->save();

        return response()->json([
            "message" => "Theme updated successfully",
            "theme" => $theme
        ], 200);
    }

    public function destroy($themeId)
    {
        $theme = Theme::find($themeId);

        if (!$theme) {
            return response()->json(["message" => "Theme with id $themeId not found"], 404);
        }

        if ($theme->themeImage) {
            Storage::disk('public')->delete($theme->themeImage);
        }

        $theme->delete();

        return response()->json(["message" => "Theme deleted successfully"], 200);
    }
}
    












