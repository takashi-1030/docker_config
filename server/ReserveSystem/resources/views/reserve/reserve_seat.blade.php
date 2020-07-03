@extends('layout/layout')

@section('content')
<h2>座席選択</h2>
<div class="panel panel-default">
    <div class="panel-heading">
        <label>選択した日付 | </label>
        <b>{{ $input['year'] }}年{{ $input['month'] }}月{{ $input['day'] }}日({{ $input['week'] }})</b>
    </div>
    <div class="panel-body">
        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
        <form action="/guest_info" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>「予約時間」の選択</label>
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
            </select>
        </div>
        <div class="form-group">
            <label>「座席」の選択</label>
            <img src="{{ asset('img/floor_map.jpg') }}" class="img-responsive center-block">
            <label>座席番号</label>
            <select name="seat" class="form-control" style="width:150px">
            <option disabled selected value>-</option>
            @for($i = 1;$i <= 15;$i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
            </select>
        </div>
        <input type="hidden" name="year" value="{{ $input['year'] }}">
        <input type="hidden" name="month" value="{{ $input['month'] }}">
        <input type="hidden" name="day" value="{{ $input['day'] }}">
        <input type="hidden" name="week" value="{{ $input['week'] }}">
        <input type="hidden" name="date_str" value="{{ $input['date_str'] }}">
        <input type="hidden" name="number" value="{{ $input['number'] }}">
        <input type="submit" value="お客様情報入力画面へ進む" class="btn btn-primary">
        <input type="button" value="戻る" onclick=history.back() class="btn btn-secondary">
        </form>
    </div>
</div>
@stop

@section('script')
@stop