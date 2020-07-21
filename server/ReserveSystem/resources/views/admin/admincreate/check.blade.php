@extends('layout/admin_layout')
@section('content')
<form method="post" action="/admin/adminCreate/done" id="create_form">
    <h2>管理者登録</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($error->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif
    {{ csrf_field() }}
    <table class="table">
        <tr>
            <th scope="row">管理者ID</th>
            <td>
                {{ $input['admin_id'] }}
                <input type="hidden" name="admin_id" value="{{ $input['admin_id'] }}">
            </td>
        </tr>
        <tr>
            <th scope="row">名前</th>
            <td>
                {{ $input['name'] }}
                <input type="hidden" name="name" value="{{ $input['name'] }}">
            </td>
        </tr>
        <tr>
            <th scope="row">電話番号</th>
            <td>
                {{ $input['tel'] }}
                <input type="hidden" name="tel" value="{{ $input['tel'] }}">
            </td>
        </tr>
        <tr>
            <th scope="row">メールアドレス</th>
            <td>
                {{ $input['email'] }}
                <input type="hidden" name="email" value="{{ $input['email'] }}">
            </td>
        </tr>
    </table>
    <input type="hidden" name="password" value="{{ $input['password'] }}">
    <p>以上の内容で登録します。</p>
    <br>
</form>
<input type="submit" form="create_form" value="登録" class="btn btn-primary">
<button class="btn btn-secondary" onclick="history.back()">戻る</button>
@stop