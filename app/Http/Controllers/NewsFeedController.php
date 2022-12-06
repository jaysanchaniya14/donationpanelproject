<?php

namespace App\Http\Controllers;

use App\Models\Newsfeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Exceptions\Exception;

class NewsfeedController extends Controller
{

    public function index(Request $request){
        if($request->ajax()){
            $newsfeeds = Newsfeed::with('project')->orderBy('id', 'desc')->get();

            try {
                return datatables($newsfeeds)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($row){
                        return date(getDateFormat(), strtotime($row->created_at));
                    })
                    ->addColumn('project_title', function($row){
                        return $row->project ? $row->project->title  : '-';
                    })    
                    ->make(true);
            }
            catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return view('newsfeed');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'newsfeed_images' => 'required',
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }

        $newsfeeds = new Newsfeed();
        $newsfeeds->title = $request->title;
        $newsfeeds->description = $request->description;
        $newsfeeds->activity_type = "newsfeed_updates";
        $images = [];
        if($request->hasFile('newsfeed_images')){
            foreach($request->file('newsfeed_images') as $file){
                if($path =  $this->upload_newsfeed_image($file)) {
                    $images[] = $path;
                }
            }
        }    

        $newsfeeds->media = $images;
        $newsfeeds->save();
        return $this->respondSuccess("New newsfeed has been added");
    }

    public function view(Request $request , $id)
    {
        $newsfeed = Newsfeed::find($id);
        return $this->respondWithData($newsfeed, "Newsfeed details");
    }

    public function edit(Request $request, Newsfeed $newsfeed){
        return $this->respondWithData($newsfeed, "News feed data");
    }

    public function update(Request $request, Newsfeed $newsfeed){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:25',
            'description' => 'required|max:500',
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }

        $images = $newsfeed->media;

        if($request->newsfeed_removed_images){
            foreach($request->newsfeed_removed_images as $file){
                $this->removeFile(public_path($file));
                if (($key = array_search($file, $images)) !== false) {
                    unset($images[$key]);
                }
            }
        }
    
        $newsfeed->title = $request->title;
        $newsfeed->description = $request->description;

        if($request->hasFile('newsfeed_images')){
            foreach($request->file('newsfeed_images') as $file){
                if(in_array($file->getClientOriginalExtension(), $this->allowed_videos)){
                    $images = [];
                }
                if($path =  $this->upload_newsfeed_image($file)) {
                    $images[] = $path;
                }
            }
        }
        $newsfeed->media = array_values($images);
        $newsfeed->save();

        return $this->respondSuccess("News feed updated successfully");
    }

    public function destroy(Request $request, Newsfeed $newsfeed){
        foreach($newsfeed->media as $file){
            $this->removeFile(public_path($file));
        }

        $newsfeed->delete();
        return $this->respondSuccess("Newsfeed has been removed");
    }
}
