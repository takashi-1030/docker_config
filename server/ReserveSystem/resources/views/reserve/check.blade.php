@extends('layout/layout')

@section('content')
<h2>入力内容確認</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <form action="/reserve_done" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>予約日時・座席番号</label>
            <table class="table">
                <tr>
                <td>日にち</td>
                <td>{{ $info['year'] }}年{{ $info['month'] }}月{{ $info['day'] }}日({{ $info['week'] }})</td>
                </tr>
                <tr>
                <td>人数</td>
                <td>{{ $info['number'] }}名</td>
                </tr>
                <tr>
                <tr>
                <td>時間</td>
                <td>{{ $info['time'] }}～</td>
                </tr>
                <td>座席</td>
                <td>
                @foreach($info['seat'] as $seat)
                    {{ $seat }}　
                @endforeach
                </td>
                </tr>
            </table>
            <label>お客様情報</label>
            <table class="table">
                <tr>
                <td>お名前</td>
                <td>{{ $info['name'] }}</td>
                </tr>
                <tr>
                <td>電話番号</td>
                <td>{{ $info['tel'] }}</td>
                </tr>
                <tr>
                <td>メールアドレス</td>
                <td>{{ $info['email'] }}</td>
                </tr>
            </table>
        </div>
        <input type="hidden" name="name" value="{{ $info['name'] }}">
        <input type="hidden" name="tel" value="{{ $info['tel'] }}">
        <input type="hidden" name="email" value="{{ $info['email'] }}">
        <input type="hidden" name="date_str" value="{{ $info['date_str'] }}">
        <input type="hidden" name="time" value="{{ $info['time'] }}">
        <input type="hidden" name="number" value="{{ $info['number'] }}">
        @foreach($info['seat'] as $seat)
            <input type="hidden" name="seat[]" value="{{ $seat }}">
        @endforeach
        <input type="submit" value="予約" class="btn btn-primary">
        <input type="button" value="戻る" onclick=history.back() class="btn btn-secondary">
        </form>
    </div>
</div>
@stop

@section('script')
@stop