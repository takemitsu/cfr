<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['update','destroy']);
    }

    public function index(Project $project)
    {
        return Review::where('project_id', $project->id)
            ->orderBy('id', 'desc')
            ->paginate();
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'nickname' => 'required|string|min:1|max:255',
            'product_name' => 'string|nullable',
            'comment' => 'required|string',

            'score_product' => 'required|integer|min:0|max:5', // 商品
            'score_vendor' => 'required|integer|min:0|max:5', // 実行者
            'score_retry' => 'required|integer|min:0|max:5', // また買いたい
            'score_total' => 'required|integer|min:0|max:5', // 総合
        ]);

        $review = new Review();
        $review->service_id = $project->service_id;
        $review->project_id = $project->id;

        $review->nickname = $request->nickname;
        $review->product_name = $request->product_name;
        $review->comment = $request->comment;

        $review->score_product = $request->score_product;
        $review->score_vendor = $request->score_vendor;
        $review->score_retry = $request->score_retry;
        $review->score_total = $request->score_total;

        $review->save();

        return $review;
    }

    public function show(Project $project, Review $review)
    {
        return $review;
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
        return $review;
    }

    public function destroy(Project $project, Review $review)
    {
        $review->delete();
        return;
    }
}
