@extends('layout/layout')

<div class="@if($result['A-1'] == NULL)seat
            @elseif(in_array('A-1',$seats) && in_array($result['time'],$old_times['A-1']) && $result['date'] == $old_date)seat
            @endif x a_1 @if(in_array('A-1',$seats) && in_array('A-1',$after_seats))selected @endif" data-seat="A-1" data-number="4" data-type="table">4</div>
<div class="@if($result['A-2'] == NULL)seat
            @elseif(in_array('A-2',$seats) && in_array($result['time'],$old_times['A-2']) && $result['date'] == $old_date)seat
            @endif x a_2 @if(in_array('A-2',$seats) && in_array('A-2',$after_seats))selected @endif" data-seat="A-2" data-number="4" data-type="table">4</div>
<div class="@if($result['B-1'] == NULL)seat
            @elseif(in_array('B-1',$seats) && in_array($result['time'],$old_times['B-1']) && $result['date'] == $old_date)seat
            @endif y b_1 @if(in_array('B-1',$seats) && in_array('B-1',$after_seats))selected @endif" data-seat="B-1" data-number="4" data-type="table">4</div>
<div class="@if($result['B-2'] == NULL)seat
            @elseif(in_array('B-2',$seats) && in_array($result['time'],$old_times['B-2']) && $result['date'] == $old_date)seat
            @endif y b_2 @if(in_array('B-2',$seats) && in_array('B-2',$after_seats))selected @endif" data-seat="B-2" data-number="4" data-type="table">4</div>
<div class="@if($result['C-1'] == NULL)seat
            @elseif(in_array('C-1',$seats) && in_array($result['time'],$old_times['C-1']) && $result['date'] == $old_date)seat
            @endif x c_1 @if(in_array('C-1',$seats) && in_array('C-1',$after_seats))selected @endif" data-seat="C-1" data-number="4" data-type="table">4</div>
<div class="@if($result['C-2'] == NULL)seat
            @elseif(in_array('C-2',$seats) && in_array($result['time'],$old_times['C-2']) && $result['date'] == $old_date)seat
            @endif x c_2 @if(in_array('C-2',$seats) && in_array('C-2',$after_seats))selected @endif" data-seat="C-2" data-number="4" data-type="table">4</div>
<div class="@if($result['C-3'] == NULL)seat
            @elseif(in_array('C-3',$seats) && in_array($result['time'],$old_times['C-3']) && $result['date'] == $old_date)seat
            @endif x c_3 @if(in_array('C-3',$seats) && in_array('C-3',$after_seats))selected @endif" data-seat="C-3" data-number="4" data-type="table">4</div>
<div class="@if($result['D-1'] == NULL)seat
            @elseif(in_array('D-1',$seats) && in_array($result['time'],$old_times['D-1']) && $result['date'] == $old_date)seat
            @endif z d_1 @if(in_array('D-1',$seats) && in_array('D-1',$after_seats))selected @endif" data-seat="D-1" data-number="1" data-type="counter">１</div>
<div class="@if($result['D-2'] == NULL)seat
            @elseif(in_array('D-2',$seats) && in_array($result['time'],$old_times['D-2']) && $result['date'] == $old_date)seat
            @endif z d_2 @if(in_array('D-2',$seats) && in_array('D-2',$after_seats))selected @endif" data-seat="D-2" data-number="1" data-type="counter">１</div>
<div class="@if($result['D-3'] == NULL)seat
            @elseif(in_array('D-3',$seats) && in_array($result['time'],$old_times['D-3']) && $result['date'] == $old_date)seat
            @endif z d_3 @if(in_array('D-3',$seats) && in_array('D-3',$after_seats))selected @endif" data-seat="D-3" data-number="1" data-type="counter">１</div>
<div class="@if($result['D-4'] == NULL)seat
            @elseif(in_array('D-4',$seats) && in_array($result['time'],$old_times['D-4']) && $result['date'] == $old_date)seat
            @endif z d_4 @if(in_array('D-4',$seats) && in_array('D-4',$after_seats))selected @endif" data-seat="D-4" data-number="1" data-type="counter">１</div>
<div class="@if($result['D-5'] == NULL)seat
            @elseif(in_array('D-5',$seats) && in_array($result['time'],$old_times['D-5']) && $result['date'] == $old_date)seat
            @endif z d_5 @if(in_array('D-5',$seats) && in_array('D-5',$after_seats))selected @endif" data-seat="D-5" data-number="1" data-type="counter">１</div>

@section('script')
<script>
$(function(){
    $('.seat').on('click',function(){
        $('.alert').remove();
        var seat = $(this).data('seat');
        $(this).toggleClass('selected');
        if($('.' + seat).length == 0){
            $('.select').append('<span class="selected-seat ' + seat + '">' + seat + ' </span>');
            $('.select-seat').append('<input type="hidden" name="seat[]" value="' + seat + '" class="input-' + seat + '">');
        } else {
            $('.' + seat).remove();
            $('.input-' + seat).remove();
        }
        if($('.select-seat').children().length > 0){
            $('.submit').prop('disabled',false);
        } else {
            $('.submit').prop('disabled',true);
        }
    });
});
</script>
@stop