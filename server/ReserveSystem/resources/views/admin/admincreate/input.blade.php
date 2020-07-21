@extends('layout/admin_layout')
@section('content')
<form method="post" action="/admin/adminCreate">
    <h2>管理者登録</h2>
    {{ csrf_field() }}
    <label>管理者ID</label>
    <div class="form-group">
        <input type="text" name="admin_id" placeholder="半角英数を入力してください"
            class="form-control
        @if(!empty($errors->first('admin_id')))
            border-danger
        @endif"
        value="{{ old('admin_id') }}">
        <p>
            <span class="help-block text-danger">
                {{$errors->first('admin_id')}}
            </span>
        </p>
    </div>
    <label>パスワード</label>
    <div class="form-group">
        <input type="password" name="password" placeholder="半角英数を入力してください"
        class="form-control
        @if(!empty($errors->first('name')))
            border-danger
        @endif">
        <p>
            <span class="help-block text-danger">
                {{$errors->first('password')}}
            </span>
        </p>
    </div>
    <label>名前</label>
    <div class="form-group">
        <input type="text" name="name" placeholder="名前を入力してください"
        class="form-control
        @if(!empty($errors->first('name')))
            border-danger
        @endif"
        value="{{ old('name') }}">
        <p>
            <span class="help-block text-danger">
                {{$errors->first('name')}}
            </span>
        </p>
    </div>
    <label>電話番号</label>
    <div class="form-group">
        <input type="text" name="tel" placeholder="電話番号を入力してください"
        class="form-control
        @if(!empty($errors->first('tel')))
            border-danger
        @endif"
        value="{{ old('tel') }}">
        <p>
            <span class="help-block text-danger">
                {{$errors->first('tel')}}
            </span>
        </p>
    </div>
    <label>メールアドレス</label>
    <div class="form-group">
        <input type="text" name="email" placeholder="メールアドレスを入力してください"
        class="form-control
        @if(!empty($errors->first('email')))
            border-danger
        @endif"
        value="{{ old('email') }}">
        <p>
            <span class="help-block text-danger">
                {{$errors->first('email')}}
            </span>
        </p>
    </div>
    <input type="submit" value="登録" class="btn btn-primary">
    <a href="/admin/list" class="btn btn-secondary">戻る</a>
</form>
@stop