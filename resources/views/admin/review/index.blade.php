@extends('layouts.admin')

@section('content')

    <section id="review-list">

        <form method="GET" action="{{route('admin.review.index')}}">
            <div class="form-row mb-3">
                <div class="col-2">
                    <select class="form-control" name="service_id">
                        <option value="">--</option>
                        @foreach($servicers as $servicer)
                            <option value="{{$servicer->id}}" {{old('service_id') == $servicer->id ? "selected" : ""}} >{{$servicer->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-1">
                    <input type="text" class="form-control" name="project_id" value="{{old('project_id')}}"
                           placeholder="project id">
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" name="search" value="{{old('search')}}"
                           placeholder="project name">
                </div>
                <div class="col-2">
                    <input type="text" class="form-control" name="nickname" value="{{old('nickname')}}"
                           placeholder="nickname">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary">検索</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover bg-white" style="width: 1500px;">
                <thead>
                <tr>
                    <th scope="col" class="text-nowrap" style="width: 60px;">id</th>
                    <th scope="col" class="text-nowrap" style="width: 140px;">商品名</th>
                    <th scope="col" class="text-nowrap" style="width: 120px;">ニックネーム</th>
                    <th scope="col" class="text-nowrap" style="width: 40px;">商</th>
                    <th scope="col" class="text-nowrap" style="width: 40px;">実</th>
                    <th scope="col" class="text-nowrap" style="width: 40px;">再</th>
                    <th scope="col" class="text-nowrap" style="width: 40px;">総</th>
                    <th scope="col" class="text-nowrap" style="width: 300px;">コメント</th>
                    <th scope="col" class="text-nowrap" style="width: 120px;">更新日</th>
                    <th scope="col" class="text-nowrap" style="width: 120px;">操作</th>
                    <th scope="col" class="text-nowrap" style="width: 100px;">サービサー</th>
                    <th scope="col" class="text-nowrap" style="width: 300px;">プロジェクト</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reviews as $review)
                    <tr>
                        <th scope="row">{{$review->id}}</th>
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
                                <a href="{{route('admin.project.review.edit', [$review->project->id, $review->id])}}"
                                   class="btn btn-warning btn-sm">編集</a>
                                <button type="button" class="btn btn-danger btn-sm"
                                        onclick="deleteProjectReview({{$review->project->id}}, {{$review->id}})">削除
                                </button>
                            </div>
                        </td>
                        <td>
                            {{$review->service->name}}
                        </td>
                        <td>
                            <a href="{{route('admin.project.review.index', [$review->project->id])}}">
                                {{$review->project->title}}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($reviews->total() == 0)
            <div class="alert alert-warning">データが無いか検索条件にヒットしませんでした。</div>
    @endif

    {{$reviews->links()}}

    <!-- Error Message -->
        <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-content border-0">
                        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる"><span
                                        aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> <span id="errorMessage"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')
    <script type="text/javascript">
        const deleteProjectReview = (project_id, review_id) => {
            if (confirm('id:' + review_id + ' を削除しますか')) {
                axios({
                    method: 'delete',
                    url: '/admin/project/' + encodeURIComponent(project_id) + '/review/' + encodeURIComponent(review_id),
                })
                    .then((a, b, c) => {
                        console.log(a, b, c)
                        location.reload()
                    })
                    .catch((error) => {
                        console.log(error)
                        $('#errorMessage').text(error.message)
                        $('#alertModal').modal('show')
                    })
            }
        }
    </script>
@endsection
