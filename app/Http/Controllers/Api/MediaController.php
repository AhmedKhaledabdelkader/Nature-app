<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;

class MediaController extends Controller
{
    

    public function show($filename)
    {
   
   try{
        // Clean any output that might have been started
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        $path = storage_path("app/private/{$filename}");
        
        if (!file_exists($path)) {
            return response()->json(['message' => 'Media not found'], 404);
        }
        
        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
        ]);


    }catch(Throwable $e){


        return response()->json([

            "status"=>"error",
            "message"=>"an error occurred while retrieving media",
            "error"=>$e->getMessage()

        ],500);




    }

    }





}
