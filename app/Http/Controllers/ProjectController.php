<?php

namespace App\Http\Controllers;

use App\Models\Newsfeed;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Exceptions\Exception;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $projects = Project::whereNull('user_id')->orderBy('id', 'desc')->get();

            try {
                return datatables($projects)
                    ->addIndexColumn()
                    ->editColumn('start_date', function ($row) {
                        return date(getDateFormat(), strtotime($row->start_date));
                    })
                    ->editColumn('end_date', function ($row) {
                        return $row->end_date ? date(getDateFormat(), strtotime($row->end_date)) : '-';
                    })
                    ->editColumn('raised_amount', function ($row) {
                        return '$' . number_format($row->raised_amount, 2);
                    })
                    ->editColumn('goal', function ($row) {
                        if (!$row->goal) {
                            return '-';
                        }
                        return '$' . number_format($row->goal, 2);
                    })
                    ->make(true);
            } catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return view('projects.index');
    }

    public function create(Request $request)
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cover_image' => 'required',
            'project_images.*' => 'required|mimes:jpg,jpeg,png|max:5120',
            'project_title' => 'required|max:50',
            'project_type' => 'required|in:ongoing,fixed_goal',
            'donation_type_en' => 'required',
            'donation_type_de' => 'required',
            'exchange_rate' => 'required',
            'project_goal' => 'required_if:project_type,==,fixed_goal',
            'start_date' => 'required',
            'target_date' => 'required_if:project_type,==,fixed_goal',
            'location' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }

        $project = new Project();
        $project->title = $request->project_title;
        $project->type = ($request->project_type == "ongoing") ? 'ongoing' : 'fixed_goal';
        $project->start_date = date('Y-m-d', strtotime($request->start_date));
        $project->end_date = date('Y-m-d', strtotime($request->target_date));
        $project->goal = $request->project_goal;
        $project->donation_type = ['en' => $request->donation_type_en, 'de' => $request->donation_type_de];
        $project->exchange_rate = $request->exchange_rate;
        $project->location = $request->location;
        $project->description = $request->description;
        if ($request->hasFile('cover_image')) {
            if ($path = $this->upload_project_image($request->file('cover_image'))) {
                $project->cover_image = $path;
            }
        }
        $project->save();

        foreach ($request->file('project_images') as $file) {
            if ($path = $this->upload_project_image($file)) {
                $image = new ProjectImage();
                $image->project_id = $project->id;
                $image->image = $path;
                $image->save();
            }
        }

        return $this->respondSuccess("New project has been added successfully");
    }

    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'project_title' => 'required|max:50',
            'project_type' => 'required|in:ongoing,fixed_goal',
            'donation_type_en' => 'required',
            'donation_type_de' => 'required',
            'exchange_rate' => 'required',
            'project_goal' => 'required_if:project_type,==,fixed_goal',
            'start_date' => 'required',
            'target_date' => 'required_if:project_type,==,fixed_goal',
            'location' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }

        $old = $project;

        $project = Project::find($old->id);
        $project->title = $request->project_title;
        $project->type = ($request->project_type == "ongoing") ? 'ongoing' : 'fixed_goal';
        $project->start_date = date('Y-m-d', strtotime($request->start_date));
        $project->end_date = date('Y-m-d', strtotime($request->target_date));
        $project->goal = $request->project_goal;
        $project->donation_type = ['en' => $request->donation_type_en, 'de' => $request->donation_type_de];
        $project->exchange_rate = $request->exchange_rate;
        $project->location = $request->location;
        $project->description = $request->description;
        if ($request->hasFile('cover_image')) {
            if ($path = $this->upload_project_image($request->file('cover_image'))) {
                $project->cover_image = $path;
                $this->removeFile(public_path($old->cover_image));
            }
        }
        $project->save();

        if ($request->removed_files) {
            foreach ($request->removed_files as $file) {
                $this->removeFile(public_path($file));
                ProjectImage::where('image', $file)->delete();
            }
        }

        if ($request->hasFile('project_images')) {
            foreach ($request->file('project_images') as $file) {
                if ($path = $this->upload_project_image($file)) {
                    $image = new ProjectImage();
                    $image->project_id = $project->id;
                    $image->image = $path;
                    $image->save();
                }
            }
        }

        return $this->respondSuccess("Project details has been updated successfully");
    }

    public function destroy(Request $request, Project $id)
    {
        foreach ($id->images as $image) {
            $this->removeFile(public_path($image->image));
        }
        $this->removeFile(public_path($id->cover_image));
        $id->delete();

        return $this->respondSuccess("Project has been removed");
    }

    public function changeStatus(Request $request, Project $id)
    {
        $id->is_active = !$id->is_active;

        $id->save();

        if ($id->is_active) {
            return $this->respondSuccess("Project has been activated");
        } else {
            return $this->respondSuccess("Project has been deactivated");
        }
    }

    public function edit(Request $request, Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function addNewsFeed(Request $request, Project $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:25',
            'description' => 'required|max:500',
            'newsfeed_images' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }

        $feed = new Newsfeed();
        $feed->project_id = $id->id;
        $feed->activity_type = "project_updates";
        $feed->title = $request->title;
        $feed->description = $request->description;

        $images = [];
        if ($request->hasFile('newsfeed_images')) {
            foreach ($request->file('newsfeed_images') as $file) {
                if ($path = $this->upload_newsfeed_image($file)) {
                    $images[] = $path;
                }
            }
        }
        $feed->media = $images;
        $feed->save();

        return $this->respondSuccess("News feed added successfully");
    }

    public function newsFeeds(Request $request, Project $id)
    {
        if ($request->ajax()) {
            $projects = Newsfeed::where('project_id', $id->id)
                ->orderBy('id', 'desc')->get();

            try {
                return datatables($projects)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($row) {
                        return date(getDateFormat(), strtotime($row->created_at));
                    })
                    ->addColumn('likes_count', function($row){
                        return $row->newsFeeds ? $row->newsFeeds->likes_count : '-';
                    })
                    ->make(true);
            } catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
        $project = $id;
        return view('projects.newsfeeds', compact('project'));
    }

    public function subProjects(Request $request, Project $project)
    {
        if ($request->ajax()) {
            $projects = Project::with('user')->where('parent_id', $project->id)->orderBy('id', 'desc')->get();

            try {
                return datatables($projects)
                    ->addIndexColumn()
                    ->editColumn('start_date', function ($row) {
                        return date(getDateFormat(), strtotime($row->start_date));
                    })
                    ->editColumn('end_date', function ($row) {
                        return $row->end_date ? date(getDateFormat(), strtotime($row->end_date)) : '-';
                    })
                    ->editColumn('user.profile', function($row){
                        return $row->user->profile ?? asset('assets/media/dummy-user.png');
                    })
                    ->editColumn('raised_amount', function ($row) {
                        return '$' . number_format($row->raised_amount, 2);
                    })
                    ->editColumn('goal', function ($row) {
                        if (!$row->goal) {
                            return '-';
                        }
                        return '$' . number_format($row->goal, 2);
                    })
                    ->addColumn('user_name', function($row){
                        return $row->user ? $row->user->first_name.' '.$row->user->last_name : '-';
                    })
                    ->make(true);
            } catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return view('projects.sub-projects', compact('project'));
    }

    public function allSubProjects(Request $request){
        if($request->ajax()){
            $projects = Project::with('user')
                ->with('parent_project')
                ->whereNotNull('parent_id')
                ->orderBy('id', 'desc')->get();

            try {
                return datatables($projects)
                    ->addIndexColumn()
                    ->editColumn('start_date', function ($row) {
                        return date(getDateFormat(), strtotime($row->start_date));
                    })
                    ->editColumn('user.profile', function($row){
                        return $row->user->profile ?? asset('assets/media/dummy-user.png');
                    })
                    ->editColumn('end_date', function ($row) {
                        return $row->end_date ? date(getDateFormat(), strtotime($row->end_date)) : '-';
                    })
                    ->editColumn('raised_amount', function ($row) {
                        return '$' . number_format($row->raised_amount, 2);
                    })
                    ->editColumn('goal', function ($row) {
                        if (!$row->goal) {
                            return '-';
                        }
                        return '$' . number_format($row->goal, 2);
                    })
                    ->addColumn('user_name', function($row){
                        return $row->user ? $row->user->first_name.' '.$row->user->last_name : '-';
                    })
                    ->make(true);
            } catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }

        return view('sub-projects.index');
    }

    public function editSubProject(Request $request, $id){
        $project = Project::with('parent_project')
            ->find($id);

        return view('sub-projects.edit', compact('project'));
    }

    public function updateSubProject(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'project_title' => 'required|max:50',
            'project_goal' => 'required',
            'start_date' => 'required',
            'target_date' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }

        $old = $project;

        $project = Project::find($old->id);
        $project->title = $request->project_title;
        $project->start_date = date('Y-m-d', strtotime($request->start_date));
        $project->end_date = date('Y-m-d', strtotime($request->target_date));
        $project->goal = $request->project_goal;
        $project->description = $request->description;
        if ($request->hasFile('cover_image')) {
            if ($path = $this->upload_project_image($request->file('cover_image'))) {
                $project->cover_image = $path;
                $this->removeFile(public_path($old->cover_image));
            }
        }
        $project->save();

        if ($request->removed_files) {
            foreach ($request->removed_files as $file) {
                $this->removeFile(public_path($file));
                ProjectImage::where('image', $file)->delete();
            }
        }

        if ($request->hasFile('project_images')) {
            foreach ($request->file('project_images') as $file) {
                if ($path = $this->upload_project_image($file)) {
                    $image = new ProjectImage();
                    $image->project_id = $project->id;
                    $image->image = $path;
                    $image->save();
                }
            }
        }

        return $this->respondSuccess("Sub Project details has been updated successfully");
    }


    public  function view( $id)
    {
        return view('projects.view')
        ->with('project', Project::find($id));
    }


    public function viewnewsFeeds(Request $request, Project $id)
    {
        if ($request->ajax()) {
            $projects = Newsfeed::where('project_id', $id->id)
                ->orderBy('id', 'desc')->get();

            try {
                return datatables($projects)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($row) {
                        return date(getDateFormat(), strtotime($row->created_at));
                    })
                    ->addColumn('likes_count', function($row){
                        return $row->newsFeeds ? $row->newsFeeds->likes_count : '-';
                    })
                    ->make(true);
            } catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
        $project = $id;
        return view('projects.view', compact('project'));
    }

    public function viewsubProjects(Request $request, Project $project)
    {
        if ($request->ajax()) {
            $projects = Project::with('user')->where('parent_id', $project->id)->orderBy('id', 'desc')->get();

            try {
                return datatables($projects)
                    ->addIndexColumn()
                    ->editColumn('start_date', function ($row) {
                        return date(getDateFormat(), strtotime($row->start_date));
                    })
                    ->editColumn('end_date', function ($row) {
                        return $row->end_date ? date(getDateFormat(), strtotime($row->end_date)) : '-';
                    })
                    ->editColumn('user.profile', function($row){
                        return $row->user->profile ?? asset('assets/media/dummy-user.png');
                    })
                    ->editColumn('raised_amount', function ($row) {
                        return '$' . number_format($row->raised_amount, 2);
                    })
                    ->editColumn('goal', function ($row) {
                        if (!$row->goal) {
                            return '-';
                        }
                        return '$' . number_format($row->goal, 2);
                    })
                    ->addColumn('user_name', function($row){
                        return $row->user ? $row->user->first_name.' '.$row->user->last_name : '-';
                    })
                    ->make(true);
            } catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return view('projects.view', compact('project'));
    }
}
