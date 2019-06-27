@extends('layouts.admin')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="text-right">
                <a href="{{route('admin.service.create')}}" class="btn btn-primary">新サービス</a>
            </div>

            <table class="table table-hover bg-white">
                <thead>
                <tr>
                    <th style="width: 60px;">id</th>
                    <th style="width: 60px;">favicon</th>
                    <th>名前</th>
                    <th></th>
                    <th style="width: 130px;">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>{{$service->id}}</td>
                        <td>
                            <img src="{{$service->favicon}}" style="max-width: 48px; max-height: 48px;"/>
                        </td>
                        <td>{{$service->name}}</td>
                        <td>
                            <a class="btn btn-link btn-sm"
                               href="{{route('admin.project.index',['service_id' => $service->id])}}">登録プロジェクト一覧</a>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{route('admin.service.edit', [$service->id])}}"
                                   class="btn btn-warning btn-sm">編集</a>
                                <button type="button" class="btn btn-danger btn-sm"
                                        onclick="deleteService({{$service->id}})">
                                    削除
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{$services->links()}}

        </div>
    </div>
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

@endsection
@section('javascript')

    <script type="text/javascript">
        const deleteService = (id) => {
            if (confirm('id:' + id + ' を削除しますか')) {
                axios({
                    method: 'delete',
                    url: '/admin/service/' + encodeURIComponent(id),
                })
                    .then((a, b, c) => {
                        console.log(a, b, c);
                        location.reload()
                    })
                    .catch((error) => {
                        console.log(error);
                        $('#errorMessage').text(error.message);
                        $('#alertModal').modal('show');
                    })
            }
        };
    </script>
@endsection
