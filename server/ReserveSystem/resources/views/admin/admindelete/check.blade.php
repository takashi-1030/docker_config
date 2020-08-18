@extends('layout/admin_layout')
@section('content')
<form method="post" action="/admin/admindelete/done/{{ $data->id }}"id="delete_form">
    <h2>管理者削除</h2>
    {{ csrf_field() }}
    <table class="table">
        <tr>
            <th scope="row">名前</th>
            <td>
                {{ $data->name }}
            </td>
        </tr>
    </table>
    <p>管理者を削除します。</p>
    <br>
</form>
<input type="submit" form="delete_form" value="削除" class="btn btn-danger">
<button class="btn btn-secondary" onclick="history.back()">戻る</button>
@stop
