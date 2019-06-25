<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $request->validate([
            'service_id' => 'nullable|integer',
            'search' => 'nullable|string|min:0|max:255',
        ]);

        // そのうちソート追加する

        $projects = Project::with('service')
            ->with('reviews')
            ->orderBy('id', 'desc');

        if($request->filled('service_id')) {
            $projects = $projects->where('service_id', $request->service_id);
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

        return view('admin.project.index', ['projects' => $projects]);
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'url' => 'required|url',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'url',
        ]);

        $project->service_id = $request->service_id;
        $project->url = $request->url;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->image_url = $request->image_url;
        $project->save();

        return $project;
    }

    public function destroy(Project $project)
    {
        // TODO: レビューがあるときは削除させないとか。

        $project->delete();
        return;
    }
}
