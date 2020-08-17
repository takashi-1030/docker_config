@extends('layout/layout')

@php
  $date_str = date('Y年n月j日',strtotime($date['date']));
  $week = date('w',strtotime($date['date']));
  $week_str = ['日','月','火','水','木','金','土'];
@endphp

@section('styles')
<link href="{{ asset('carousel/slick.css') }}" rel='stylesheet' />
<link href="{{ asset('carousel/slick-theme.css') }}" rel='stylesheet' />
<link href="{{ asset('carousel/carousel.css') }}" rel='stylesheet' />
<link href="{{ asset('css/floor_map.css') }}" rel='stylesheet' />
<script type="text/javascript" src="{{ asset('carousel/slick.min.js') }}"></script>
@stop

@section('content')
<h2>新規予約追加</h2>
<div class="panel panel-default">
    <div class="panel-heading">
        <label>選択した日付 | </label>
        <b>{{ $date_str }}({{ $week_str[$week] }})</b>
    </div>
    <div class="panel-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif
        <form action="/admin/add" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>利用人数</label>
            <input type="text" name="number" style="width:100px" class="form-control @if(!empty($errors->first('number')))border-danger @endif" value="{{ old('number') }}">
        </div>
        <div class="form-group">
            <label>「予約時間」の選択</label>
            <div class="slick" data-slick='{"slidesToShow": 7, "slidesToScroll": 1}'>
            @foreach($schedule as $time)
                <div class="btn-carousel" data-time="{{ date('G:i',strtotime($time['time'])) }}">{{ date('G:i',strtotime($time['time'])) }}～</div>
            @endforeach
            </div>
        </div>
        <div class="form-group">
            <label>「座席」の選択</label>
            <div class="explanation">
                <ul class="description">
                    <li><span class="selectable-seat"></span>：選択可能</li>
                    <li><span class="active-seat"></span>：選択中</li>
                    <li><span class="inactive-seat"></span>：選択不可</li>
                </ul>
            </div>
            <div id="select" class="select panel panel-default" data-total="0">
                <label class="panel-body">選択した座席 |</label>
            </div>
            <div class="floor-map">
                <div class="seats">
                <div class="x a_1">4</div>
                <div class="x a_2">4</div>
                <div class="y b_1">4</div>
                <div class="y b_2">4</div>
                <div class="x c_1">4</div>
                <div class="x c_2">4</div>
                <div class="x c_3">4</div>
                <div class="z d_1">１</div>
                <div class="z d_2">１</div>
                <div class="z d_3">１</div>
                <div class="z d_4">１</div>
                <div class="z d_5">１</div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>お名前</label>
            <input type="text" name="name" class="form-control @if(!empty($errors->first('name')))border-danger @endif" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label>電話番号</label>
            <input type="text" name="tel" class="form-control @if(!empty($errors->first('tel')))border-danger @endif" value="{{ old('tel') }}">
        </div>
        <input type="hidden" name="date" value="{{ $date['date'] }}" class="date">
        <input type="hidden" name="time" value="" class="time">
        <div class="select-seat"></div>
        <input type="submit" value="確認" class="btn btn-primary submit" disabled>
        <input type="button" value="戻る" onclick=history.back() class="btn btn-secondary">
        </form>
    </div>
</div>
@stop

@section('script')
<script>
$(document).ready(function(){
    $('.slick').slick({
        speed: 250,
        infinite: false,
    });
});

function dispLoading(msg){
    if(msg == undefined){
        msg = "";
    }
    var dispMsg = "<div class='loadingMsg'>" + msg + "</div>";
    if($("#loading").length == 0){
    $(".seats").html("<div id='loading'>" + dispMsg + "</div>");
  }
}

$(function(){
    $('.btn-carousel').on('click',function(){
        dispLoading();
        $('#select').children('span').remove();
        $('.select-seat').children().remove();
        var date = $('.date').val();
        var time = $(this).data('time');
        $('.btn-carousel').css('background-color','#3097D1');
        $(this).css('background-color','orange');
        $('.time').val(time);
        var data = {
            'date': date,
            'time': time
            };
        $.ajax({
          type: 'get',
          data: data,
          datatype: 'html',
          url: '/admin/add/seat'
        })
        .done(function(view){
          $('.seats').html(view);
        })
        .fail(function(view){
          alert('error');
        });
    });
});
</script>
@stop