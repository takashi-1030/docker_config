@extends('layout/layout')

@section('content')
<h2>お客様情報入力</h2>
<div class="panel panel-default">
    <div class="panel-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif
        <form action="/check" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>お名前</label>
            <input type="text" name="name" class="form-control @if(!empty($errors->first('name')))border-danger @endif" value="{{ old('name') }}"><br>
            <label>電話番号</label>
            <input type="text" name="tel" class="form-control @if(!empty($errors->first('tel')))border-danger @endif" value="{{ old('tel') }}"><br>
            <label>メールアドレス</label>
            <input type="text" name="email" class="form-control @if(!empty($errors->first('email')))border-danger @endif" value="{{ old('email') }}"><br>
        </div>
        <input type="hidden" name="year" value="{{ $r_info['year'] }}">
        <input type="hidden" name="month" value="{{ $r_info['month'] }}">
        <input type="hidden" name="day" value="{{ $r_info['day'] }}">
        <input type="hidden" name="week" value="{{ $r_info['week'] }}">
        <input type="hidden" name="date_str" value="{{ $r_info['date_str'] }}">
        <input type="hidden" name="number" value="{{ $r_info['number'] }}">
        <input type="hidden" name="time" value="{{ $r_info['time'] }}">
        @foreach($r_info['seat'] as $seat)
            <input type="hidden" name="seat[]" value="{{ $seat }}">
        @endforeach
        <input type="submit" value="確認" class="btn btn-primary">
        <input type="button" value="戻る" onclick=history.back() class="btn btn-secondary">
        </form>
    </div>
</div>
@stop

@section('script')
@stop