@extends('layouts.admin')

@section('content')

    <section id="project-detail">

        <table class="table border-0">
            <tr>
                <td class="border-0">
                    <img src="{{$project->image_url}}" style="max-width: 200px; max-height: 200px;"/>
                </td>
                <td class="border-0">
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
                <th style="width: 60px;">id</th>
                <th style="width: 140px;">商品名</th>
                <th style="width: 120px;">ニックネーム</th>
                <th style="width: 40px;">商</th>
                <th style="width: 40px;">実</th>
                <th style="width: 40px;">再</th>
                <th style="width: 40px;">総</th>
                <th>コメント</th>
                <th style="width: 120px;">更新日</th>
                <th style="width: 120px;">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td>{{$review->id}}</td>
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
                               class="btn btn-warning btn-sm">編集</a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="deleteProjectReview({{$project->id}}, {{$review->id}})">削除</button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{$reviews->links()}}

        <!-- Error Message -->
        <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-content border-0">
                        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる"><span aria-hidden="true">&times;</span></button>
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
