@extends('layout/admin_layout')
@section('content')
<div>
    <h2 class="d-inline-block">管理者一覧</h2>
    <a href="/admin/admincreate" class="btn btn-primary float-right">登録</a>
</div>
@if (isset($adminlist))
<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>管理者ID</th>
            <th>名前</th>
            <th>電話番号</th>
            <th>メールアドレス</th>
            <th>作成日</th>
            <th>削除</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($adminlist as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->admin_id }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->tel }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ date('Y/m/d', strtotime($item->updated_at)) }}</td>
        <td>
        <a href="/admin/admindelete/{{ $item->id }}"class="btn btn-danger">削除</a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
<p>管理者は登録されていませんでした。</p>
@endif
@stop