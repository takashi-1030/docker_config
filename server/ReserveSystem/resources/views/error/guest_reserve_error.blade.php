@extends('layout/layout')

@section('content')
<h2>予約エラー</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <h2>ご予約できませんでした</h2>
        <p>お客様が選択した日時・座席はすでに予約されています。<br>お手数おかけしますが、最初から選択しなおしてください。</p>
        <a href="/" class="btn btn-primary">TOPに戻る</a>
    </div>
</div>
@stop