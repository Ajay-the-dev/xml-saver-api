<?php

namespace App\Http\Controllers;

use App\Models\xml;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class XmlController extends Controller
{
    public function saveXml(Request $request)
    {
        try {


            $validate = Validator::make($request->all(),[
                "title" => "required",
                "description" => "required",
                "code"=>"required"

            ]);

            if($validate->fails())
            {
                return response()->json([
                "status" => 0,
                "message"=> 'form validation failed',
                "data" => null
                ]);
            }else
            {

                
                $existing = Xml::where('title', $request->title)->where('description', htmlspecialchars($request->description))->where('code', htmlspecialchars($request->code))->first();

                if ($existing) {
                    return response()->json([
                        "status" => 0,
                        "message" => 'These data already exists',
                        "data" => null
                    ]); 
                }

                xml::create([
                    "title" => $request->title,
                    "description" => htmlspecialchars($request->description),
                    "code" => htmlspecialchars($request->code)
                ]);
            }


            return response()->json([
                "status" => 1,
                "message"=> 'Saved successfully',
                "data" => null
            ]);
            
        } catch (\Throwable $th) {
           return response()->json([
                "status" => 0,
                "message"=> 'unable to save',
                "data" => null
            ]);
        }
    }

    public function getXml(Request $request)
    {
        try {
          
                $order  = $request->sortBy;


                $orderBy = $order == 'DESC' ? 'desc' : 'asc';
                $xml = Xml::orderBy('id', $orderBy)
                    ->paginate(5);
                return response()->json([
                    "status" => 1,
                    "message" => "fetched successfully",
                    "data" => $xml
                ]);
        } catch (\Throwable $th) {
            return response()->json([
                    "status" => 0,
                    "message" => "Something went wrong while fetching stored xml",
                    "data" => null
                ]);
        }
    }

    public function getXmlByToday(Request $request)
    {
        try {
          
                $today = now()->format('Y-m-d');

                $xml = Xml::whereDate('created_at', $today)
                        ->orderBy('id', 'desc')
                        ->take(10)
                        ->get();

                return response()->json([
                    "status" => 1,
                    "message" => "fetched successfully",
                    "data" => $xml
                ]);
        } catch (\Throwable $th) {
            return response()->json([
                    "status" => 0,
                    "message" => "Something went wrong while fetching stored xml for today",
                    "data" => null
                ]);
        }
    }

    public function deleteXml(Request $request)
    {
        try {

                

                $validate = Validator::make($request->all(),[
                    "id" => "required|integer"
                ]);

                if($validate->fails())
                {
                    return response()->json([
                        "status" => 0,
                        "message"=> "Invalid parameter",
                        "data" => null

                    ]);
                }
                else{

                    $existing = xml::find($request->id);

                    if(!$existing)
                    {
                        return response()->json([
                            "status" => 0,
                            "message"=> "Entry not existing",
                            "data" => null
                        ]);
                    }

                    $existing->delete();
                    return response()->json([
                        "status" => 1,
                        "message"=> "Deleted successfully",
                        "data" => null
                    ]);
                }
        } catch (\Throwable $th) {
           return response()->json([
                            "status" => 0,
                            "message"=> "Something went wrong while deleting",
                            "data" => null
                        ]);
        }
    }

    public function searchXml(Request $request)
    {
        try {

            
            $query = xml::query();
            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->filled('description')) {
                $query->orWhere('description', 'like', '%' . htmlspecialchars($request->description) . '%');
            }

            if ($request->filled('code')) {
                $query->orWhere('code', 'like', '%' . htmlspecialchars($request->code) . '%');
            }

            $xmlData = $query->paginate(5);

            return response()->json([
                "status" => 1,
                "message" => "successfully search Completed",
                "data" => $xmlData
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                "status" => 0,
                "message" => "Something went wrong while searching",
                "data" => null
            ]);
        }
    }

    public function updateXml(Request $request)
    {
        try {
            
            $xmlData = xml::find($request->id);

            if($xmlData != null)
            {
                $xmlData->title = $request->title;
                $xmlData->description = htmlspecialchars($request->description);
                $xmlData->code = htmlspecialchars($request->code);

                 $validate = Validator::make($request->all(),[
                    "title" => "required",
                    "description" => "required",
                    "code"=>"required"
                ]);

                if($validate->fails())
                {
                    return response()->json([
                            "status" => 0,
                            "message" => "validation errors",
                            "data" =>  $validate->errors()->all()
                        ]);
                }
                else{


                    $existing = Xml::where('title', $request->title)->where('description', htmlspecialchars($request->description))->where('code', htmlspecialchars($request->code))->first();

                    if ($existing) {
                        return response()->json([
                            "status" => 0,
                            "message" => 'These data already exists',
                            "data" => null
                        ]); 
                    }



                    $xmlData->save();
                    return response()->json([
                                "status" => 1,
                                "message" => "Xml updated successfully",
                                "data" =>  $xmlData
                            ]);
                }
            }
            else{
                 return response()->json([
                            "status" => 0,
                            "message" => "File not found to update",
                            "data" =>  null
                        ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                            "status" => 0,
                            "message" => "Something went wrong while updating ..",
                            "data" =>  null
                        ]);
        }
    }

}
