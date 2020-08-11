@extends('layout/admin_layout')
@section('content')
<div>
    <h2 class="d-inline-block">お客様一覧</h2>
</div>
@if (isset($customerList))
<table class="table table-hover">
    <thead>
        <tr>
            <th>名前</th>
            <th>電話番号</th>
            <th>メールアドレス</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($customerList as $item)
    <tr>
        <td>{{ $item->name }}</td>
        <td>{{ $item->tel }}</td>
        <td>{{ $item->email }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
<p>お客様は登録されていませんでした</p>
@endif
@stop