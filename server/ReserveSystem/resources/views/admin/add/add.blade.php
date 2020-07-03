@extends('layout/admin_layout')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<link href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css" rel="stylesheet">
@stop

@section('content')
<h2>新規予約追加</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <form action="/admin/add" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>予約日</label>
            <input type="text" name="date" id="date" @if(isset($date['date'])) value="{{ $date['date'] }}" @endif class="form-control"><br>
            <label>予約時間</label>
            <select name="time" class="form-control" style="width: 150px">
            <option value="17:00">17:00～</option>
            <option value="17:30">17:30～</option>
            <option value="18:00">18:00～</option>
            <option value="18:30">18:30～</option>
            <option value="19:00">19:00～</option>
            <option value="19:30">19:30～</option>
            <option value="20:00">20:00～</option>
            <option value="20:30">20:30～</option>
            <option value="21:00">21:00～</option>
            <option value="21:30">21:30～</option>
            <option value="22:00">22:00～</option>
            <option value="22:30">22:30～</option>
            <option value="23:00">23:00～</option>
            <option value="23:30">23:30～</option>
            </select><br>
            <label>人数</label>
            <select name="number" class="form-control" style="width:150px">
            <option disabled selected value>-</option>
            @for($i = 1;$i <= 10;$i++)
            <option value="{{ $i }}">{{ $i }}名</option>
            @endfor
            </select><br>
            <label>座席番号</label>
            <select name="seat" class="form-control" style="width:150px">
            <option disabled selected value>-</option>
            @for($i = 1;$i <= 15;$i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
            </select><br>
            <label>お名前</label>
            <input type="text" name="name" class="form-control"><br>
            <label>電話番号</label>
            <input type="text" name="tel" class="form-control"><br>
            <label>メールアドレス</label>
            <input type="text" name="email" class="form-control"><br>
        </div>
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