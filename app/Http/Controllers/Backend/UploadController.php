<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function uploadRedactor(Request $request)
    {
        if(\Storage::disk('uploads')->put('',$request->file('file')[0])) {

            $filename = $request->file('file')->getClientOriginalName();
            $mime     = $request->file('file')->getMimeType();

            $array = ['file' =>
                [
                    'url'  => secure_asset('/uploads/'.$filename),
                    'name' => $filename,
                    'id'   => md5(date('YmdHis'))
                ]
            ];

            return response()->json($array);
        }
    }

    public function imageJson()
    {
        $files = \Storage::disk('uploads')->files();
        $data   = [];

        if(!empty($files)) {
            foreach($files as $file) {
                $mime = \File::mimeType(public_path('uploads/'.$file));

                if(substr($mime, 0, 5) == 'image') {
                    $data[] = ['url' => secure_asset('uploads/' . $file), 'thumb' => secure_asset( 'uploads/' . $file), 'title' => $file];
                }
            }
        }

        return response()->json($data);
    }

    public function fileJson()
    {
        $files  = \Storage::disk('fileuploads')->files();
        $data   = [];

        if(!empty($files)) {
            foreach($files as $file) {
                $mime = \File::mimeType(public_path('uploads/'.$file));

                if(substr($mime, 0, 5) != 'image') {
                    $data[] = ['name' => $file, 'url' => secure_asset('uploads/'.$file), 'title' => $file];
                }
            }
        }

        return response()->json($data);
    }

}
