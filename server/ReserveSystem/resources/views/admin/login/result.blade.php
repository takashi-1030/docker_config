@extends('layout/layout')
@section('content')
<h1>ログイン入力内容</h1>
<div class="row">
    <div class="col-sm-12">
        <a href="/admin/login" class="btn btn-primary" style="margin:20px;">
        ログイントップページに戻る
        </a>
    </div>
</div>

<table class="table table-striped">
    <tr>
        <td>id</td>
        <td>
        {{-- ここにはadminPostLogin()から渡されたデータが入る --}}
        </td>
    </tr>
    <tr>
        <td>パスワード</td>
        <td>
        {{-- ここにはadminPostLogin()から渡されたデータが入る --}}
        </td>
    </tr>
</table>
@stop