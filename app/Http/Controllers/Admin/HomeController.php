<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $service_count = Service::count();
        $project_count = Project::count();
        $review_count = Review::count();

        return view('admin.home', [
            'service_count' => $service_count,
            'project_count' => $project_count,
            'review_count' => $review_count,
        ]);
    }
}
