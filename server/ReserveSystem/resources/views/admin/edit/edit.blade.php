@extends('layout/admin_layout')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<link href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css" rel="stylesheet">
<link href="{{ asset('carousel/slick.css') }}" rel='stylesheet' />
<link href="{{ asset('carousel/slick-theme.css') }}" rel='stylesheet' />
<link href="{{ asset('carousel/carousel.css') }}" rel='stylesheet' />
<link href="{{ asset('css/floor_map.css') }}" rel='stylesheet' />
<script type="text/javascript" src="{{ asset('carousel/slick.min.js') }}"></script>
@stop

@section('content')
<h2>予約内容変更</h2>
<div class="panel panel-default">
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
        <form action="/admin/edit/{{ $record['id'] }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label>予約日</label>
            <input type="text" name="date" id="date" class="form-control date" value="{{ $record['date'] }}">
        </div>
        <div class="form-group">
            <label>利用人数</label>
            <input type="text" name="number" value="{{ $record['number'] }}" style="width:100px" class="form-control @if(!empty($errors->first('number')))border-danger @endif">
        </div>
        <div class="form-group">
            <label>「予約時間」の選択</label>
            <div class="slick" data-slick='{"slidesToShow": 7, "slidesToScroll": 1}'>
            @foreach($schedule as $time)
                <div class="btn-carousel" data-time="{{ date('G:i',strtotime($time['time'])) }}" @if($record['time'] == $time['time']) style="background-color:orange" @endif>{{ date('G:i',strtotime($time['time'])) }}～</div>
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
            <div id="before" class="before panel panel-default" data-total="0">
                <label class="panel-body">変更前の座席 |</label>
                @foreach($seats as $seat)
                <span class="old">{{ $seat['seat'] }}</span>
                @endforeach
            </div>
            <div id="select" class="select panel panel-default" data-total="0">
                <label class="panel-body">変更後の座席 |</label>
                @foreach($seats as $seat)
                <span class="selected-seat {{ $seat['seat'] }}">{{ $seat['seat'] }}</span>
                @endforeach
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
        <input type="hidden" name="name" value="{{ $record['name'] }}">
        <input type="hidden" name="tel" value="{{ $record['tel'] }}">
        <input type="hidden" name="email" value="{{ $record['email'] }}">
        <input type="hidden" name="old_date" value="{{ $record['date'] }}" class="old_date">
        <input type="hidden" name="old_time" value="{{ $record['time'] }}" class="old_time">
        <input type="hidden" name="time" value="{{ date('G:i',strtotime($record['time'])) }}" class="time">
        <div class="select-seat">
            @foreach($seats as $seat)
            <input type="hidden" name="seat[]" value="{{ $seat['seat'] }}" class="input-{{ $seat['seat'] }}">
            @endforeach
        </div>
        @foreach($seats as $seat)
        <input type="hidden" name="old_seat[]" value="{{ $seat['seat'] }}">
        @endforeach
        <input type="submit" value="お客様情報入力画面へ進む" class="btn btn-primary submit">
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
        dateFormat: "Y-m-d",
        minDate: new Date()
    });
</script>
<script>
$(document).ready(function(){
    $('.slick').slick({
        speed: 250,
        infinite: false,
    });

    var date = $('.date').val();
    var old_date = $('.old_date').val();
    var time = $('.time').val();
    var old_time = $('.old_time').val();
    var seat = [];
    $('.old').each(function(){
        seat.push($(this).text())
    });
    var after_seat = [];
    $('.selected-seat').each(function(){
        after_seat.push($(this).text())
    });
    var data = {
        'date': date,
        'old_date': old_date,
        'time': time,
        'old_time': old_time,
        'seat': seat,
        'after_seats': after_seat
        };
    $.ajax({
        type: 'get',
        data: data,
        datatype: 'html',
        url: '/admin/seat'
    })
    .done(function(view){
        $('.seats').html(view);
    })
    .fail(function(view){
        alert('error');
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
        var old_date = $('.old_date').val();
        var time = $(this).data('time');
        var old_time = $('.old_time').val();
        var seat = [];
        $('.old').each(function(){
            seat.push($(this).text())
        });
        var after_seat = [];
        $('.selected-seat').each(function(){
            after_seat.push($(this).text())
        });
        $('.btn-carousel').css('background-color','#3097D1');
        $(this).css('background-color','orange');
        $('.time').val(time);
        var data = {
            'date': date,
            'old_date': old_date,
            'time': time,
            'old_time': old_time,
            'seat': seat,
            'after_seats': after_seat
            };
        $.ajax({
          type: 'get',
          data: data,
          datatype: 'html',
          url: '/admin/seat'
        })
        .done(function(view){
          $('.seats').html(view);
        })
        .fail(function(view){
          alert('error');
        });
        if($('.select-seat').children().length > 0){
            $('.submit').prop('disabled',false);
        } else {
            $('.submit').prop('disabled',true);
        }
    });
});
</script>
@stop