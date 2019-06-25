@extends('layouts.admin')

@section('content')

    <table class="table">
        <thead>
        <tr>
            <th style="width: 60px;">id</th>
            <th style="width: 130px;">servicer</th>
            <th style="width: 130px;">image</th>
            <th>title</th>
            <th>reviews</th>
            <th>score</th>
            <th style="width: 100px;">公式サイト</th>
            <th style="width: 130px;">operation</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td>{{$project->id}}</td>
                <td>{{$project->service->name}}</td>
                <td>
                    <img src="{{$project->image_url}}" style="max-width: 100px; max-height: 100px;" />
                </td>
                <td>
                    <a href="{{route('admin.project.review.index', [$project->id])}}">{{$project->title}}</a>
                </td>
                <td>{{$project->review_count}}</td>
                <td>{{$project->score_total}}</td>
                <td>
                    <a href="{{$project->url}}">公式サイト</a>
                </td>

                <td>
                    <div class="btn-group">
                        <a href="{{route('admin.project.edit', [$project->id])}}" class="btn btn-warning btn-sm">Edit</a>
                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$projects->links()}}
@endsection
