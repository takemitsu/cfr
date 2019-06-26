@extends('layouts.admin')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>プロジェクト更新</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{route('admin.project.update', [$project->id])}}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="servicer" class="form-label">サービサー</label>
                    <select id="servicer" name="service_id" class="form-control">
                        @foreach($servicers as $servicer)
                            <option value="{{$servicer->id}}" {{old('service_id', $project->service_id) == $servicer->id ? "selected": ""}} >{{$servicer->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="url" class="form-label">URL</label>
                    <input type="text" id="url" type="text" class="form-control" name="url"
                           value="{{old('url', $project->url)}}">
                </div>

                <div class="form-group">
                    <label for="title" class="form-label">タイトル</label>
                    <textarea rows="3" id="title" class="form-control"
                              name="title">{{old('title', $project->title)}}</textarea>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">詳細</label>
                    <textarea rows="4" id="description" class="form-control"
                              name="description">{{old('description', $project->description)}}</textarea>
                </div>

                <div class="form-group">
                    <label for="image_url" class="form-label">image_url</label>
                    <input type="text" id="image_url" type="text" class="form-control" name="image_url"
                           value="{{old('image_url', $project->image_url)}}">
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">送信</button>
                </div>
            </form>
        </div>
    </div>
@endsection
