<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $request->validate([
            'project_id' => 'nullable|integer|exists:projects,id',
            'service_id' => 'nullable|integer|exists:services,id',
            'search' => 'nullable|string|min:0|max:255',
        ]);

        // そのうちソート追加する

        $projects = Project::with('service')
            ->with('reviews')
            ->orderBy('id', 'desc');

        if($request->filled('service_id')) {
            $projects = $projects->where('service_id', $request->service_id);
        }
        if($request->filled('project_id')) {
            $projects = $projects->where('id', $request->project_id);
        }
        if ($request->filled('search')) {
            $projects = $projects->where('title', 'like', '%'.$request->search.'%');
        }

        $projects = $projects->paginate();

        foreach ($projects as $project) {
            $project->score_total = $project->reviews->avg('score_total');
            $project->review_count = $project->reviews->count();
            unset($project->reviews);
        }

        $servicers = Service::all();

        $request->flash();

        return view('admin.project.index', ['projects' => $projects, 'servicers' => $servicers]);
    }

    public function edit(Project $project)
    {
        $servicers = Service::all();
        return view('admin.project.edit', ['project' => $project, 'servicers' => $servicers]);
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'url' => 'required|url',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'url',
        ],[],[
            'service_id' => 'サービサー',
            'url' => 'URL',
            'title' => 'タイトル',
            'description' => '詳細',
            'image_url' => 'イメージURL',
        ]);

        $project->service_id = $request->service_id;
        $project->url = $request->url;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->image_url = $request->image_url;
        $project->save();

        return redirect()->route('admin.project.index');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return;
    }
}
