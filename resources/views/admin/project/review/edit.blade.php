@extends('layouts.admin')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>レビュー更新</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{route('admin.project.review.update', [$project->id, $review->id])}}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nickname" class="form-label">ニックネーム</label>
                    <input type="text" id="nickname" class="form-control" name="nickname"
                           value="{{old('nickname', $review->nickname)}}">
                </div>

                <div class="form-group">
                    <label for="product_name" class="form-label">商品名</label>
                    <input type="text" id="product_name" class="form-control" name="product_name"
                           value="{{old('product_name', $review->product_name)}}">
                </div>

                <div class="form-group">
                    <label for="comment" class="form-label">コメント</label>
                    <textarea rows="6" id="comment" class="form-control"
                              name="comment">{{old('comment', $review->comment)}}</textarea>
                </div>

                <div class="form-group">
                    <label for="comment" class="form-label">商品</label>
                    @foreach([1,2,3,4,5] as $value)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="score_product"
                                   value="{{$value}}" {{old('score_product', $review->score_product) == $value ? "checked":""}}>
                            <label class="form-check-label">{{$value}}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="comment" class="form-label">実行者</label>
                    @foreach([1,2,3,4,5] as $value)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="score_vendor"
                                   value="{{$value}}" {{old('score_vendor', $review->score_vendor) == $value ? "checked":""}}>
                            <label class="form-check-label">{{$value}}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="comment" class="form-label">再購買</label>
                    @foreach([1,2,3,4,5] as $value)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="score_retry"
                                   value="{{$value}}" {{old('score_retry', $review->score_retry) == $value ? "checked":""}}>
                            <label class="form-check-label">{{$value}}</label>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="comment" class="form-label">総合</label>
                    @foreach([1,2,3,4,5] as $value)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="score_total"
                                   value="{{$value}}" {{old('score_total', $review->score_total) == $value ? "checked":""}}>
                            <label class="form-check-label">{{$value}}</label>
                        </div>
                    @endforeach
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">送信</button>
                    <a href="{{route('admin.project.review.index', [$project->id])}}" class="btn btn-secondary">戻る</a>
                </div>
            </form>
        </div>
    </div>
@endsection
