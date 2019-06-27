@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>


                    @if (session('status'))
                        <div class="card-body">
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        </div>
                    @endif

                    <h3 class="m-3">登録状況</h3>
                    <table class="table table-hover m-0">
                        <tbody>
                        <tr>
                            <th>Service</th>
                            <td>{{$service_count}}</td>
                            <td><a class="btn btn-link btn-sm" href="{{route('admin.service.index')}}">List</a></td>
                        </tr>
                        <tr>
                            <th>Project</th>
                            <td>{{$project_count}}</td>
                            <td><a class="btn btn-link btn-sm" href="{{route('admin.project.index')}}">List</a></td>
                        </tr>
                        <tr>
                            <th>Review</th>
                            <td>{{$review_count}}</td>
                            <td><a class="btn btn-link btn-sm" href="{{route('admin.review.index')}}">List</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        注意事項
                    </div>
                    <div class="card-body">
                        各マスタ、各データは、論理削除ではなく、物理削除です。<br>
                        うっかり削除すると取り返しが付きません。
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
