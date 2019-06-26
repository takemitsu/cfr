@extends('layouts.admin')

@section('content')

    <table class="table">
        <thead>
        <tr>
            <th style="width: 60px;">id</th>
            <th style="width: 130px;">サービスサー</th>
            <th style="width: 130px;">イメージ</th>
            <th>タイトル</th>
            <th style="width: 100px;">レビュー数</th>
            <th style="width: 100px;">平均総合<br>スコア</th>
            <th style="width: 100px;">公式サイト</th>
            <th style="width: 130px;">操作</th>
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
                <td class="text-right">{{$project->review_count}}</td>
                <td class="text-right">{{$project->score_total}}</td>
                <td>
                    <a href="{{$project->url}}">公式サイト</a>
                </td>

                <td>
                    <div class="btn-group">
                        <a href="{{route('admin.project.edit', [$project->id])}}" class="btn btn-warning btn-sm">編集</a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteProject({{$project->id}})">削除</button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{$projects->links()}}

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

@endsection
@section('javascript')

    <script type="text/javascript">
        const deleteProject = (id) => {
            if (confirm('id:' + id + ' を削除しますか')) {
                axios({
                    method: 'delete',
                    url: '/admin/project/' + encodeURIComponent(id),
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