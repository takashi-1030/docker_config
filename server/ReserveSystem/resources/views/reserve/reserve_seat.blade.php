@extends('layout/layout')
@section('styles')
<link href="{{ asset('carousel/slick.css') }}" rel='stylesheet' />
<link href="{{ asset('carousel/slick-theme.css') }}" rel='stylesheet' />
<link href="{{ asset('carousel/carousel.css') }}" rel='stylesheet' />
<link href="{{ asset('css/floor_map.css') }}" rel='stylesheet' />
<script type="text/javascript" src="{{ asset('carousel/slick.min.js') }}"></script>
@stop

@section('content')
<h2>座席選択</h2>
<div class="panel panel-default">
    <div class="panel-heading">
        <label>選択した日付 | </label>
        <b>{{ $input['year'] }}年{{ $input['month'] }}月{{ $input['day'] }}日({{ $input['week'] }})</b>
    </div>
    <div class="panel-body">
        <form action="/guest_info" method="post">
        {{ csrf_field() }}
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
            <div class="error"></div>
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
        <input type="hidden" name="year" value="{{ $input['year'] }}">
        <input type="hidden" name="month" value="{{ $input['month'] }}">
        <input type="hidden" name="day" value="{{ $input['day'] }}">
        <input type="hidden" name="week" value="{{ $input['week'] }}">
        <input type="hidden" name="date_str" value="{{ $input['date_str'] }}" class="date">
        <input type="hidden" name="number" value="{{ $input['number'] }}" class="select-number">
        <input type="hidden" name="time" value="" class="time">
        <div class="select-seat"></div>
        <input type="submit" value="お客様情報入力画面へ進む" class="btn btn-primary submit" disabled>
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
        $('.alert').remove();
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
          url: '/seat'
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