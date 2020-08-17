@extends('layout/admin_layout')

@php
  $date = $record['date'];
  $date_str = date('Y年n月j日',strtotime($date));
  $week = date('w',strtotime($date));
  $week_str = ['日','月','火','水','木','金','土'];
  $time = $record['time'];
  $time_str = date('G:i',strtotime($time));
@endphp

@section('styles')
<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
@stop

@section('content')
<h2>予約内容</h2>
<div class="panel panel-default">
    <div class="panel-body">
      <label>予約日時・座席番号</label>
      <table class="table">
      <tr><td style="width:40%">日にち</td><td>{{ $date_str }}({{ $week_str[$week] }})</td></tr>
      <tr><td>時間</td><td>{{ $time_str }}～</td></tr>
      <tr><td>利用人数</td><td>{{ $record['number'] }}名</td></tr>
      <tr>
        <td>座席番号</td>
        <td>
        @foreach($seats as $seat)
          {{ $seat['seat'] }}　
        @endforeach
        </td>
      </tr>
      </table>
      <label>お客様情報</label>
      <table class="table">
      <tr><td style="width:40%">お名前</td><td>{{ $record['name'] }}様</td></tr>
      <tr><td>電話番号</td><td>{{ $record['tel'] }}</td></tr>
      <tr><td>メールアドレス</td><td>{{ $record['email'] }}</td></tr>
      </table>
      @if($record['ok_flg'] == null)
      <a class="btn btn-primary" role="button" href="/admin/confirm/{{ $record['id'] }}">予約を確定する</a>
      <a class="btn btn-danger" role="button" href="/admin/reject/{{ $record['id'] }}">予約を拒否する</a>
      @else
      <a class="btn btn-success" role="button" href="/admin/edit/{{ $record['id'] }}">予約内容を変更する</a>
      <button id="delete" class="btn btn-danger">予約を取り消す</button>
      @endif
      <a class="btn btn-secondary" role="button" href="/admin">戻る</a>
    </div>
</div>

<div class="modal date-modal">
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
        <h2>予約を消去してもよろしいですか？</h2><br>
        <form action="/admin/delete/{{ $record['id'] }}" method="get">
            <div class="form-group form-check">
              <label class="form-check-label" id="checkbox-label"><input class="form-check-input" type="checkbox" id="checkbox">予約の消去を許可する</label>
            </div>
            <input type="submit" value="消去" id="submit" class="btn btn-danger" disabled>
            <button class="js-modal-close btn btn-secondary">戻る</button>
        </form>
    </div>
</div>
@stop

@section('script')
<script>
  $(function(){
    $('#delete').on('click',function(){
        $('.modal').fadeIn();
    });

    $('.js-modal-close').on('click',function(){
        $('.event-modal,.date-modal').fadeOut();
        return false;
    });

    $('#checkbox').change(function(){
        $('#checkbox').each(function(){
            var check = $(this).prop('checked');
            if(check == true){
                $('#submit').prop('disabled',false);
            } else {
                $('#submit').prop('disabled',true);
            }
        });
    });
  });
</script>
@stop