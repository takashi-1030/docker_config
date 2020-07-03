@extends('layout/admin_layout')

@php
  $date = $input['date'];
  $date_str = date('Y年n月j日',strtotime($date));
  $week = date('w',strtotime($date));
  $week_str = ['日','月','火','水','木','金','土'];
  $time = $input['time'];
  $time_str = date('G:i',strtotime($time));
@endphp

@section('content')
<h2>予約内容</h2>
<div class="panel panel-default">
    <div class="panel-body">
      <label>予約日時・座席番号</label>
      <table class="table">
      <tr><td>日にち</td><td>{{ $date_str }}({{ $week_str[$week] }})</td></tr>
      <tr><td>時間</td><td>{{ $time_str }}～</td></tr>
      <tr><td>利用人数</td><td>{{ $input['number'] }}名</td></tr>
      <tr><td>座席番号</td><td>{{ $input['seat'] }}</td></tr>
      </table>
      <label>お客様情報</label>
      <table class="table">
      <tr><td>お名前</td><td>{{ $input['name'] }}様</td></tr>
      <tr><td>電話番号</td><td>{{ $input['tel'] }}</td></tr>
      <tr><td>メールアドレス</td><td>{{ $input['email'] }}</td></tr>
      </table>
      @if($input['ok_flg'] == null)
      <a class="btn btn-danger" role="button" href="/admin/confirm/{{ $input['id'] }}">予約を確定する</a>
      @endif
      <a class="btn btn-primary" role="button" href="/admin/edit/{{ $input['id'] }}">予約内容を変更する</a>
      <a class="btn btn-secondary" role="button" href="/admin">戻る</a>
    </div>
</div>
@stop