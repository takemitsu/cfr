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
            'service_id' => 'integer',
            'sort_order' => 'string|in:default,review',
            'sort_asc' => 'string|in:asc,desc',
        ]);

        // そのうちソート追加する

        return Project::paginate();
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
        return $project->load('reviews');
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
