<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class ValidatePartner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $rules=[

         

            'locale'=> ['required', 'in:ar,en'],
            'partnerName'=>["sometimes","string","max:255"],
            'partnerLogo'=>["nullable","sometimes",'image','mimes:jpeg,png,webp,jpg,gif,svg','max:2048']



        ];

        
        $validator=Validator::make($request->all(),$rules);




        if($validator->fails()){


            return response()->json([
                "status"=>"error",
                "message"=>"validation failed",
                "errors"=>$validator->errors()

            ],422);
 



        }






        return $next($request);
    }
}
