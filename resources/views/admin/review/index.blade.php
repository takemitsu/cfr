@extends('layouts.admin')

@section('content')

    <section id="project-detail">

        <table class="table">
            <tr>
                <td>
                    <img src="{{$project->image_url}}" style="max-width: 200px; max-height: 200px;"/>
                </td>
                <td>
                    <div>
                        {{$project->title}}
                    </div>
                    <div>{{$project->service->name}}</div>
                    <div>
                        <small>Total Score:</small> {{$project->score_total}}</div>
                    <div>
                        <small>Reviews:</small> {{$project->review_count}}</div>
                    <div><a href="{{$project->url}}" target="_blank">公式サイト</a></div>
                </td>
            </tr>
        </table>

        <div style="margin-bottom: 20px;">
            <div class="small">{{$project->description}}</div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>product-name</th>
                <th>nickname</th>
                <th>product</th>
                <th>vendor</th>
                <th>retry</th>
                <th>total</th>
                <th>comment</th>
                <th>updated_at</th>
                <th>operation</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td>{{$review->product_name}}</td>
                    <td>{{$review->nickname}}</td>
                    <td>{{$review->score_product}}</td>
                    <td>{{$review->score_vendor}}</td>
                    <td>{{$review->score_retry}}</td>
                    <td>{{$review->score_total}}</td>
                    <td>{{$review->comment}}</td>
                    <td>{{$review->updated_at}}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{route('admin.project.review.edit', [$project->id, $review->id])}}"
                               class="btn btn-warning btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{$reviews->links()}}

    </section>

@endsection
