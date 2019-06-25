@extends('layouts.admin')

@section('content')

    <section id="project-detail" class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-8 col-sm-12">
            <div style="margin-bottom: 20px;">

                <img src="{{$project->image_url}}" style="max-width: 200px; max-height: 200px;" />

                <div style="display: flex; flex-direction: row; margin-bottom: 10px;">
                    <div style="flex: 0 1 160px;">
                        <div class="text-center">{{$project->service->name}}</div>
                        <div class="text-center">
                            {{$project->score_total}}
                        </div>
                        <div class="text-center">{{$project->review_count}}
                            <small>Reviews</small>
                        </div>
                        <div class="text-center">
                            <a href="{{$project->url}}" target="_blank">公式サイト</a>
                        </div>
                    </div>
                    <div style="flex: 1 2 auto;">
                        {{$project->title}}
                    </div>
                </div>

                <div class="small">{{$project->description}}</div>
            </div>

            @foreach($reviews as $review)
                <div>
                    <hr>
                    @if($review->product_name)
                        <div style="margin-bottom: 10px; font-weight: bold;">
                            {{$review->product_name}}
                        </div>
                    @endif
                    <div style="white-space: pre-wrap; margin-bottom: 10px;">{{$review->comment}}</div>

                    <div>
                        <small style="margin-right: 10px;">商　品:</small>
                        {{$review->score_product}}
                    </div>
                    <div>
                        <small style="margin-right: 10px;">実行者:</small>
                        {{$review->score_vendor}}
                    </div>
                    <div>
                        <small style="margin-right: 10px;">再購買:</small>
                        {{$review->score_retry}}
                    </div>
                    <div>
                        <small style="margin-right: 10px;">総　合:</small>
                        {{$review->score_total}}
                    </div>

                    <div class="text-right">{{$review->updated_at}}</div>
                    <div class="text-right">{{$review->nickname}}</div>
                </div>
            @endforeach

            @if($reviews->total() == 0)
                <div>条件に一致するレビューはありませんでした。</div>
            @endif


            {{$reviews->links()}}

        </div>
    </section>

@endsection
