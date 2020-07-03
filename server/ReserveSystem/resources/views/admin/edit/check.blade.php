@extends('layout/admin_layout')

@php
  $date = $input['date'];
  $date_str = date('Y年n月j日',strtotime($date));
  $week = date('w',strtotime($date));
  $week_str = ['日','月','火','水','木','金','土'];
@endphp

@section('content')
<h2>変更内容確認</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <form action="/admin/edit/done/{{ $input['id'] }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>予約日時・座席</label>
            <table class="table">
                <tr>
                <td>日にち</td>
                <td>{{ $date_str }}({{ $week_str[$week] }})</td>
                </tr>
                <tr>
                <td>時間</td>
                <td>{{ $input['time'] }}～</td>
                </tr>
                <tr>
                <td>人数</td>
                <td>{{ $input['number'] }}名</td>
                </tr>
                <tr>
                <td>座席</td>
                <td>{{ $input['seat'] }}</td>
                </tr>
            </table>
            <label>お客様情報</label>
            <table class="table">
                <td>お名前</td>
                <td>{{ $input['name'] }}</td>
                </tr>
                <tr>
                <td>電話番号</td>
                <td>{{ $input['tel'] }}</td>
                </tr>
                <tr>
                <td>メールアドレス</td>
                <td>{{ $input['email'] }}</td>
                </tr>
            </table>
        </div>
        <input type="hidden" name="name" value="{{ $input['name'] }}">
        <input type="hidden" name="tel" value="{{ $input['tel'] }}">
        <input type="hidden" name="email" value="{{ $input['email'] }}">
        <input type="hidden" name="date" value="{{ $input['date'] }}">
        <input type="hidden" name="time" value="{{ $input['time'] }}">
        <input type="hidden" name="number" value="{{ $input['number'] }}">
        <input type="hidden" name="seat" value="{{ $input['seat'] }}">
        <input type="submit" value="変更" class="btn btn-primary">
        <input type="button" value="戻る" onclick=history.back() class="btn btn-secondary">
        </form>
    </div>
</div>
@stop