<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function getOgp(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url',
        ]);
        $content = file_get_contents($request->url);

        return \ogp\Parser::parse($content);
    }

    public function index(Request $request)
    {
        $request->validate([
            'service_id' => 'nullable|integer',
            'sort_order' => 'string|in:default,review',
            'sort_asc' => 'string|in:asc,desc',
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
        return $projects;
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'service_id' => 'required|exists:services,id',
            'url' => 'required|url',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|string|url',
        ]);

        $services = Service::all();
        $service = null;
        foreach ($services as $s) {
            if (Str::startsWith($request->url, $s->url)) {
                $service = $s;
                break;
            }
        }

        if ($service == null) {
            abort(500, '指定のサービスは対応しておりません。');
        }

        $project = new Project();
        $project->service_id = $service->id;
        $project->url = $request->url;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->image_url = $request->image_url;
        $project->save();

        return $project;
    }

    public function show(Project $project)
    {
        $project->load('reviews');
        $project->score_total = $project->reviews->avg('score_total');
        $project->review_count = $project->reviews->count();
        unset($project->reviews);

        return $project->load('service');
    }
}
