@extends('layout/admin_layout')
@section('content')

<h2>検索結果</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <table class="table">
            <tr><th>予約日</th><th>予約時間</th><th>お客様氏名</th><th>電話番号</th><th>メールアドレス</th></tr>
            @foreach($record as $item)
            <tr>
                <td>{{ $item['date'] }}</td>
                <td>{{ $item['time'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['tel'] }}</td>
                <td>{{ $item['email'] }}</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@stop