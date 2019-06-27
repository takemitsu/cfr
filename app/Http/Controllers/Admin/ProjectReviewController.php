<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Project $project)
    {
        $project->load('reviews')
            ->load('service');;
        $project->score_total = $project->reviews->avg('score_total');
        $project->review_count = $project->reviews->count();
        unset($project->reviews);

        $reviews = Review::where('project_id', $project->id)
            ->orderBy('id', 'desc')
            ->paginate();

        return view('admin.project.review.index', [
            'project' => $project,
            'reviews' => $reviews,
        ]);
    }

    public function edit(Project $project, Review $review)
    {
        return view('admin.project.review.edit', [
            'project' => $project,
            'review' => $review,
        ]);
    }

    public function update(Request $request, Project $project, Review $review)
    {
        $request->validate([
            'nickname' => 'required|string|min:1|max:255',
            'product_name' => 'string|nullable',
            'comment' => 'required|string',

            'score_product' => 'required|integer|min:1|max:5', // 商品
            'score_vendor' => 'required|integer|min:1|max:5', // 実行者
            'score_retry' => 'required|integer|min:1|max:5', // また買いたい
            'score_total' => 'required|integer|min:1|max:5', // 総合
        ]);
        $review->nickname = $request->nickname;
        $review->product_name = $request->product_name;
        $review->comment = $request->comment;

        $review->score_product = $request->score_product;
        $review->score_vendor = $request->score_vendor;
        $review->score_retry = $request->score_retry;
        $review->score_total = $request->score_total;
        $review->save();

        return redirect()->route('admin.project.review.index', [$project->id]);
    }

    public function destroy(Project $project, Review $review)
    {
        $review->delete();
        return;
    }
}
