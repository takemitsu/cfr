@extends('layouts.admin')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(empty($service))
                <h1>サービサー追加</h1>
            @else
                <h1>サービサー更新</h1>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{empty($service) ? route('admin.service.store') : route('admin.service.update', [$service->id ])}}">
                @csrf
                @unless(empty($service))
                    @method('PUT')
                @endunless

                <div class="form-group">
                    <label for="name" class="form-label">サービス名</label>
                    <input type="text" id="name" class="form-control" name="name"
                           value="{{old('name', !empty($service) ? $service->name: '')}}">
                </div>

                <div class="form-group">
                    <label for="url" class="form-label">url</label>
                    <input type="text" id="url" class="form-control" name="url"
                           value="{{old('url', !empty($service) ? $service->url: '')}}">
                </div>

                <div class="form-group">
                    <label for="favicon" class="form-label">favicon</label>
                    <input type="text" id="favicon" class="form-control" name="favicon"
                           value="{{old('favicon', !empty($service) ? $service->favicon: '')}}">
                </div>


                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">送信</button>
                    <a href="{{route('admin.service.index')}}" class="btn btn-secondary">戻る</a>
                </div>
            </form>
        </div>
    </div>
@endsection
