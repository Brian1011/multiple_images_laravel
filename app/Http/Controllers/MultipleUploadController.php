<?php

namespace App\Http\Controllers;

use App\Models\Image;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MultipleUploadController extends Controller
{
    public function store(Request $request)
    {
            error_log('API HAS BEEN HIT');
            if(!$request->hasFile('fileName')) {
                return response()->json(['upload_file_not_found'], 400);
            }

            $allowedFileExtension=['jpg','png'];
            $files = $request->file('fileName');
            error_log($files);
            $errors = [];

            // treat it as an array of files
            foreach ($files as $file) {
                error_log("MULTIPLE FILES");
                error_log($file);

                $extension = $file->getClientOriginalExtension();

                $check = in_array($extension,$allowedFileExtension);

                if($check) {
                    foreach($request->fileName as $mediaFiles) {

                        error_log($mediaFiles);
                        //store image in any method you prefer as a single image

                        /*
                                                $path = $mediaFiles->store('public/images');
                                                $name = $mediaFiles->getClientOriginalName();

                                                //store image file into directory and db
                                                $save = new Image();*/


                        /*

                         $filename = time().'.png';

                         //Save Image

                         \Storage::disk($path)->put($filename, base64_decode($image));

                        */

                        /*$save->title = $name;
                        $save->path = $path;
                        $save->save();*/
                    }
                } else {
                    return response()->json(['invalid_file_format'], 422);
                }
            }
        error_log("COMPLETE");

            return response()->json(['file_uploaded'], 200);
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
