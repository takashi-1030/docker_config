@extends('layout/layout')

@section('content')
<h2>予約エラー</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <h2>予約できません</h2>
        <p>選択した日時・座席はすでに予約されています。<br>最初から選択しなおして下さい。</p>
        <a href="/admin" class="btn btn-primary">TOPに戻る</a>
    </div>
</div>
@stop