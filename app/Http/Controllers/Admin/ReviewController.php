<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $request->validate([
            'service_id' => 'nullable|integer|exists:services,id',
            'project_id' => 'nullable|integer|exists:projects,id',
            'search' => 'nullable|string',
            'nickname' => 'nullable|string',
        ]);

        $reviews = Review::orderBy('id', 'desc')
            ->with('service')
            ->with('project');

        if ($request->filled('service_id')) {
            $reviews = $reviews->where('service_id', $request->service_id);
        }
        if ($request->filled('project_id')) {
            $reviews = $reviews->where('project_id', $request->project_id);
        }
        if ($request->filled('search')) {
            $project_ids = Project::where('title', 'like', '%'.$request->search.'%')
                ->pluck('id');
            $reviews = $reviews->whereIn('project_id', $project_ids);
        }
        if ($request->filled('nickname')) {
            $reviews = $reviews->where('nickname', 'like', '%'.$request->nickname.'%');
        }

        $reviews = $reviews->paginate();

        $servicers = Service::all();

        $request->flash();

        return view('admin.review.index', [
            'reviews' => $reviews,
            'servicers' => $servicers,
        ]);
    }
}
