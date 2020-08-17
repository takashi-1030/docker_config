@extends('layout/admin_layout')

@section('content')
<h2>設定</h2>
<div class="panel panel-default">
    <div class="panel-heading">
        <label>予約受付時間変更</label>
    </div>
    <div class="panel-body">
        <form action="/admin/config/time" method="post">
        {{ csrf_field() }}
        <label>受付開始時刻</label>
        <div class="form-group form-inline">
            <select name="start_g" class="form-control" style="width: 100px">
            <option disabled selected value>-</option>
            @for($i = 1;$i <= 24;$i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
            </select>
            <label class="mx-1">：</label>
            <select name="start_i" class="form-control" style="width: 100px">
            <option disabled selected value>-</option>
            <option value="00">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
            </select>
        </div>
        <label>受付終了時刻</label>
        <div class="form-group form-inline">
            <select name="end_g" class="form-control" style="width: 100px">
            <option disabled selected value>-</option>
            @for($i = 1;$i <= 24;$i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
            </select>
            <label class="mx-1">：</label>
            <select name="end_i" class="form-control" style="width: 100px">
            <option disabled selected value>-</option>
            <option value="00">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
            </select>
        </div>
        <input type="submit" value="変更" class="btn btn-primary">
        </form>
    </div>
</div>
@stop