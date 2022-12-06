<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Newsfeed;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function explore(Request $request){
        $fixed_projects = Project::with('sub_projects', 'donations')
            ->where('is_active', 1)
            ->where('type', 'fixed_goal')
            ->whereNull('parent_id')
            ->orderBy('id', 'desc')->take(3)
            ->get();

        $ongoing_projects = Project::with('sub_projects', 'donations')
            ->where('is_active', 1)
            ->where('type', 'ongoing')
            ->whereNull('parent_id')
            ->orderBy('id', 'desc')->take(3)
            ->get();

        $response['fixed_projects'] = $fixed_projects;
        $response['ongoing_projects'] = $ongoing_projects;

        $response['first_time_donor'] = true;
        if(Auth::user()){
            $response['first_time_donor'] = Auth::user()->donations()->count() == 0;
        }

        return $this->respondWithAdditionalData('Explore data', ['explore_data' => $response] ,"success");
    }

    public function statistics(Request $request, $full_response = true){

        $response['last_day_donation'] = Donation::where('payment_status', 'success')
            ->whereRaw('DATE(created_at) = \''.date('Y-m-d',strtotime("-1 days")).'\'')
            ->sum('amount');

        $donation = Donation::where('payment_status', 'success');
        $response['total_donations'] = $donation->sum('amount');
        $response['donation_count'] = $donation->count();
        $response['total_projects'] = Project::where('is_active', 1)->count();

        $response['last_three_months_project'] = Project::where('completion_date', '>=', date('Y-m-d',strtotime("-3 months")))->count();

        if($full_response){
            return $this->respondWithAdditionalData('Statistical data', ['stat' => $response] ,"success");
        }

        return $response;
    }

    public function index(Request $request){
        $per_page = 10;

        if($request->type == "main_projects"){
            $per_page = 20;
        }

        $query = Project::with('sub_projects', 'donations', 'parent_project')
            ->where(function($q) use($request){
                if($request->search){
                    $q->where('title', 'like', '%'. $request->search .'%')
                        ->orWhereHas('sub_projects', function ($q) use ($request){
                        if($request->search){
                            $q->where('title', 'like', '%'. $request->search .'%');
                        }
                    });
                }
            })->where(function($q) use ($request){
                if($request->type == "sub_projects"){
                    $q->whereNotNull('parent_id');
                }
                else if($request->type == "main_projects"){
                    $q->whereNull('parent_id');
                }
                else if($request->type){
                    $q->where('type', $request->type);
                    if($request->type == "ongoing"){
                        $q->orWherehas('parent_project', function ($q) use ($request){
                            $q->where('type', $request->type);
                        });
                    }
                }
            })->where('is_active', 1);

        if($request->sort == "last_published"){
            $query->orderBy('created_at', 'desc');
        }
        else if($request->sort == "goal_percentage"){
            $query->orderBy(Donation::selectRaw('(SUM(amount) * 100)/ projects.goal')
                ->where('payment_status', 'success')
                ->whereColumn('donations.project_id', 'projects.id'), 'desc');
        }
        else{
            $query->orderBy(Donation::selectRaw('count(id)')
                ->where('payment_status', 'success')
                ->whereColumn('donations.project_id', 'projects.id'), 'desc');
        }

        $projects= $query->paginate($per_page);

        $urls['urls'] = [
            'next_url' => $projects->nextPageUrl(),
            'prev_url' => $projects->previousPageUrl(),
        ];
        return $this->respondWithAdditionalData("projects", array_merge(['projects' => $projects->items()], $urls), 'success');
    }

    public function newsFeed(Request $request, Project $project){
        return $this->respondWithAdditionalData("newsfeed", ['newsfeed' => $project->newsfeed], 'success');
    }

    public function userProjects(Request $request){
        $projects = Project::with('donations', 'parent_project')
            ->where('is_active', 1)
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->toSql();

        $urls['total'] = $projects->total();

        return $this->respondWithAdditionalData("projects", array_merge(['projects' => $projects->items()], $urls), 'success');
    }

    public function createSubProject(Request $request){
        $parent = Project::find($request->project_id);

        if(!$parent){
            return $this->respondWithError("Project not found");
        }

        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            'title' => 'required|max:50',
            'end_date' => 'required',
            'goal' => 'required',
            'description' => 'required',
            'cover_image' => 'required',
            'images' => 'required',
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        $project = new Project();
        $project->user_id = Auth::user()->id;
        $project->parent_id = $request->project_id;
        $project->title = $request->title;
        $project->type = 'fixed_goal';
        $project->start_date = date('Y-m-d');
        $project->end_date = $request->end_date;
        $project->goal = $request->goal;
        $project->description = $request->description;

        $project->donation_type = $parent->donation_type;
        $project->exchange_rate = $parent->exchange_rate;
        $project->location = $parent->location;

        if($request->hasFile('cover_image')){
            if($path =  $this->upload_project_image($request->file('cover_image'))){
                $project->cover_image = $path;
            }
        }
        $project->save();

        foreach($request->file('images') as $file){
            if($path =  $this->upload_project_image($file)) {
                $image = new ProjectImage();
                $image->project_id = $project->id;
                $image->image = $path;
                $image->save();
            }
        }

        $project = Project::with( 'parent_project')
            ->where('id', $project->id)->first();

        $project->donations = [];

        return $this->respondWithAdditionalData("sub_project", ['sub_project' => $project], 'success');
    }

    public function destroy(Request $request, Project $project){
        if(Auth::user()->id != $project->user_id){
            return $this->respondWithError("You can not delete this project");
        }
        foreach($project->images as $image){
            $this->removeFile(public_path($image->image));
        }
        $this->removeFile(public_path($project->cover_image));
        $project->delete();

        return $this->respondSuccess("Project has been removed");
    }

    public function update(Request $request, Project $project){
        if($project->user_id != Auth::user()->id){
            return $this->respondWithError("You can not edit this project");
        }

        $parent = Project::find($request->project_id);
        if(!$parent){
            return $this->respondWithError("Project not found");
        }

        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            'title' => 'required|max:50',
            'end_date' => 'required',
            'goal' => 'required',
            'description' => 'required',
        ]);
        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        $project->parent_id = $request->project_id;
        $project->title = $request->title;
        $project->type = $parent->type;
        $project->end_date = $request->end_date;
        $project->goal = $request->goal;
        $project->description = $request->description;

        $project->donation_type = $parent->donation_type;
        $project->exchange_rate = $parent->exchange_rate;
        $project->location = $parent->location;

        if($request->hasFile('cover_image')){
            if($path =  $this->upload_project_image($request->file('cover_image'))){
                $this->removeFile(public_path($project->cover_image));
                $project->cover_image = $path;
            }
        }
        $project->save();

        if($request->hasFile('images')){
            foreach($request->file('images') as $file){
                if($path =  $this->upload_project_image($file)) {
                    $image = new ProjectImage();
                    $image->project_id = $project->id;
                    $image->image = $path;
                    $image->save();
                }
            }
        }

        if($request->removed_files){
            foreach($request->removed_files as $file){
                $this->removeFile(public_path($file));
                ProjectImage::where('image', $file)->delete();
            }
        }

        $project = Project::with( 'parent_project')
            ->where('id', $project->id)->first();

        $project->donations = [];

        return $this->respondWithAdditionalData("sub_project", ['sub_project' => $project], 'success');
    }
}
