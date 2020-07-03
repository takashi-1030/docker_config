@extends('layout/admin_layout')

@php
  $time = $input['time'];
  $time_str = date('G:i',strtotime($time));
@endphp

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<link href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css" rel="stylesheet">
@stop

@section('content')
<h2>予約内容変更</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <form action="/admin/edit/{{ $input['id'] }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>予約日</label>
            <input type="text" name="date" id="date" value="{{ $input['date'] }}" class="form-control"><br>
            <label>予約時間</label>
            <select name="time" class="form-control" style="width: 150px">
            <option value="17:00" @if($time_str == '17:00') selected @endif>17:00～</option>
            <option value="17:30" @if($time_str == '17:30') selected @endif>17:30～</option>
            <option value="18:00" @if($time_str == '18:00') selected @endif>18:00～</option>
            <option value="18:30" @if($time_str == '18:30') selected @endif>18:30～</option>
            <option value="19:00" @if($time_str == '19:00') selected @endif>19:00～</option>
            <option value="19:30" @if($time_str == '19:30') selected @endif>19:30～</option>
            <option value="20:00" @if($time_str == '20:00') selected @endif>20:00～</option>
            <option value="20:30" @if($time_str == '20:30') selected @endif>20:30～</option>
            <option value="21:00" @if($time_str == '21:00') selected @endif>21:00～</option>
            <option value="21:30" @if($time_str == '21:30') selected @endif>21:30～</option>
            <option value="22:00" @if($time_str == '22:00') selected @endif>22:00～</option>
            <option value="22:30" @if($time_str == '22:30') selected @endif>22:30～</option>
            <option value="23:00" @if($time_str == '23:00') selected @endif>23:00～</option>
            <option value="23:30" @if($time_str == '23:30') selected @endif>23:30～</option>
            </select><br>
            <label>人数</label>
            <select name="number" class="form-control" style="width:150px">
            @for($i = 1;$i <= 10;$i++)
            <option value="{{ $i }}" @if($input['number'] == $i) selected @endif>{{ $i }}名</option>
            @endfor
            </select><br>
            <label>座席番号</label>
            <select name="seat" class="form-control" style="width:150px">
            @for($i = 1;$i <= 15;$i++)
            <option value="{{ $i }}" @if($input['seat'] == $i) selected @endif>{{ $i }}</option>
            @endfor
            </select><br>
            <label>お名前</label>
            <input type="text" name="name" class="form-control" value="{{ $input['name'] }}"><br>
            <label>電話番号</label>
            <input type="text" name="tel" class="form-control" value="{{ $input['tel'] }}"><br>
            <label>メールアドレス</label>
            <input type="text" name="email" class="form-control" value="{{ $input['email'] }}"><br>
        </div>
        <input type="hidden" name="id" value="{{ $input['id'] }}">
        <input type="submit" value="確認" class="btn btn-primary">
        <input type="button" value="戻る" onclick=history.back() class="btn btn-secondary">
        </form>
    </div>
</div>
@stop

@section('script')
<script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
<script>
    flatpickr(document.getElementById('date'),{
        locale: 'ja',
        dateFormat: "Y/m/d",
        minDate: new Date()
    });
</script>
@stop