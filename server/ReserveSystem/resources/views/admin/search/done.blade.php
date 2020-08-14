@extends('layout/admin_layout')
@section('content')

<h2>検索結果</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <table class="table">
            <tr><th>予約日</th><th>予約時間</th><th>お客様氏名</th><th></th></tr>
            @foreach($record as $item)
            <tr>
                <td>{{ $item['date'] }}</td>
                <td>{{ date('G:i',strtotime($item['time'])) }}～</td>
                <td>{{ $item['name'] }}</td>
                <td><a class="btn btn-primary" role="button" href="/admin/reserve/{{ $item['id'] }}">詳細を見る</a></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@stop