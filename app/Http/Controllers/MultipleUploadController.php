<?php

namespace App\Http\Controllers;

use App\Models\Image;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MultipleUploadController extends Controller
{
    public function store(Request $request) {
        // check request file
        if( !$request->hasFile('fileName')) {
            return response()->json([
                'status_code' => 422,
                'message' => 'No images given'
            ], 422);
        }

        error_log($request);

        //check count
        // return count(collect($request->file('fileName')));

        try {
            // store on images/resources
            // php artisan storage:link
            foreach($request->file('fileName') as $file) {
                error_log($file);
                $file->store('images/resource');
                // create new instance of image
                $save = new Image();
                //get path and file name
                $path = $file->store('public/images');
                $name = $file->getClientOriginalName();
                // add path and filename to image model
                $save->title = $name;
                $save->path = $path;
                //save new record
                $save->save();


            }
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Failed: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status_code' => 200,
            'message' => 'Image saved'
        ], 200);
    }

    public function tesStore(){
        return response()->json(['Home'], 200);
    }

    public function testStore(Request $request){
        error_log('Some message here.');
        error_log($request);
        Log::info('This is some useful');
        return response()->json(['Home'], 200);
    }
}
