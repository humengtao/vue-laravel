@extends('layouts.app')

@section('tab',6)

@section('title', 'Notifications')

@section('content')
    <div class="row">
        <div class="col-sm-10  col-md-10 col-xs-12">
            <h1 class="page-header">
                Notifications
            </h1>
            @if(Auth::user()->notifications->where('type','App\Notifications\Notify')->count()>0)
                <ul class="list-group list-unstyled">
                    <form action="/notification" method="post">
                        @foreach(Auth::user()->notifications->where('type','App\Notifications\Notify') as $notification)
                            <li class="list-group-item">
                                <p><input type="checkbox" name="{{ $notification->id }}"
                                          value="{{ $notification->id }}">
                                    <label for="{{ $notification->id }}" style="display: initial;">
                                            [系统通知] :{{ $notification->data['content'] }}
                                    </label></p>
                                <p>
                                    <span class="badge">{{ $notification->created_at->timezone('Asia/Chongqing') }}</span>
                                </p>
                            </li>
                        @endforeach
                        <input type="submit" value="删除选中" class="btn btn-danger" style="margin-top: 20px">
                        <input type="button" value="全选" class="btn btn-warning choose-all" style="margin-top: 20px">
                    </form>
                </ul>
            @else
                <h4>
                    没有新通知
                    <small><a href="/article/all">返回博客公园</a></small>
                </h4>
            @endif
        </div>
    </div>

    <script>
        $(function () {
            $('.choose-all').click(function () {
                $('input[type=checkbox]').attr('checked', true);
            });
        })
    </script>
@endsection