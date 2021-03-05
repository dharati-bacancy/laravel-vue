<?php

namespace App\Http\Controllers\Api;

use App\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Helpers\ImageUploadHelper;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {

            if(isset($request->name) && !empty($request->name)) {
                $resources = Resource::where('name', 'LIKE', '%' . $request->name . '%')->get()->sortByDesc('id');
            } else {
                $resources = Resource::orderBy('id', 'DESC')->get();
            }

            if (count($resources) > 0) {
                $response = [
                    'msg' => 'List of Resource',
                    'status' => 1,
                    'resources' => $resources,
                ];
            } else {
                $response = [
                    'msg' => 'No resource found',
                    'status' => 0,
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'msg' => $e->getMessage() . " " . $e->getFile() . " " . $e->getLine(),
                'status' => 0,
            ];
        }

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'image' => 'mimes:jpeg,png,jpg'
            ]);
            if ($validator->fails()) {
                $response = [
                    'msg' => $validator->errors(),
                    'status' => 0,
                ];
            }

            if($request->image) {
                $image = ImageUploadHelper::imageupload($request, 'image');
            } else {
                $image = Resource::DEFAULT_PATH;
            }
            $resource = Resource::create([
                'name' => $request->name,
                'image' => $image
            ]);
            
            if ($resource) {
                $response = [
                    'msg' => 'Resource created Successfully',
                    'status' => 1,
                ];
            } else {
                $response = [
                    'msg' => 'Oops! Something went wrong',
                    'status' => 0,
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'msg' => $e->getMessage() . " " . $e->getFile() . " " . $e->getLine(),
                'status' => 0,
            ];
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource, $id)
    {
        try {
            $resource = Resource::whereId($id)->first();

            if ($resource) {
                $response = [
                    'msg' => 'Resource details',
                    'status' => 1,
                    'resource' => $resource,
                ];
            } else {
                $response = [
                    'msg' => 'No such resource found in the system',
                    'status' => 0,
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'msg' => $e->getMessage() . " " . $e->getFile() . " " . $e->getLine(),
                'status' => 0,
            ];
        }

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                $response = [
                    'msg' => $validator->errors->all(),
                    'status' => 0,
                ];
            }
            $data = [];
            if($request->image) {
                $image = ImageUploadHelper::imageupload($request, 'image');
                $data['image'] = $image;
                $data['name'] = $request->name;
            } else {
                $data['name'] = $request->name;
            }
            $resource = Resource::where('id', $request->id)->update($data);
            
            if ($resource) {
                $response = [
                    'msg' => 'Resource Edit Successfully',
                    'status' => 1,
                ];
            } else {
                $response = [
                    'msg' => 'Oops! Something went wrong',
                    'status' => 0,
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'msg' => $e->getMessage() . " " . $e->getFile() . " " . $e->getLine(),
                'status' => 0,
            ];
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $delete = Resource::findOrFail($request->id);

            if ($delete) {
                $delete->delete();
                $resource = Resource::all();

                $response = [
                    'msg' => 'Resource deleted successfully',
                    'status' => 1,
                    'resource' => $resource,
                ];
            } else {
                $response = [
                    'msg' => 'No such resource found in the system',
                    'status' => 0,
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'msg' => $e->getMessage() . " " . $e->getFile() . " " . $e->getLine(),
                'status' => 0,
            ];
        }

        return response()->json($response);
    }
}
