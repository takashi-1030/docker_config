@extends('layout/layout')

@section('content')
<h2>お客様情報入力</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <form action="/check" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>お名前</label>
            <input type="text" name="name" class="form-control"><br>
            <label>電話番号</label>
            <input type="text" name="tel" class="form-control"><br>
            <label>メールアドレス</label>
            <input type="text" name="email" class="form-control"><br>
        </div>
        <input type="hidden" name="year" value="{{ $r_info['year'] }}">
        <input type="hidden" name="month" value="{{ $r_info['month'] }}">
        <input type="hidden" name="day" value="{{ $r_info['day'] }}">
        <input type="hidden" name="week" value="{{ $r_info['week'] }}">
        <input type="hidden" name="date_str" value="{{ $r_info['date_str'] }}">
        <input type="hidden" name="number" value="{{ $r_info['number'] }}">
        <input type="hidden" name="time" value="{{ $r_info['time'] }}">
        <input type="hidden" name="seat" value="{{ $r_info['seat'] }}">
        <input type="submit" value="確認" class="btn btn-primary">
        <input type="button" value="戻る" onclick=history.back() class="btn btn-secondary">
        </form>
    </div>
</div>
@stop

@section('script')
@stop