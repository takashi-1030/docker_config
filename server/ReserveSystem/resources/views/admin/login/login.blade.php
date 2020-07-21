@extends('layout/layout')
@section('content')
<form method="post" action="/admin/login">
    <h2>ログイン</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif
    {{ csrf_field() }}
    <label>ID</label>
    <div class="form-group">
        <input type="text" name="admin_id"
        class="form-control @if(!empty($errors->first('admin_id')))border-danger
    @endif">
    </div>
    <label>パスワード</label>
    <div class="form-group">
        <input type="password" name="password" class="form-control">
    </div>
    <br>
    <a href="/admin" class="btn btn-secondary">ログイン</a>
    {{-- 
    <input type="submit" value="ログイン" class="btn btn-primary">
    --}}
</form>
@stop