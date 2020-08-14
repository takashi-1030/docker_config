@extends('layout/layout')

<div class="@if($result['A-1'] == NULL)seat @endif x a_1" data-seat="A-1" data-number="4" data-type="table">4</div>
<div class="@if($result['A-2'] == NULL)seat @endif x a_2" data-seat="A-2" data-number="4" data-type="table">4</div>
<div class="@if($result['B-1'] == NULL)seat @endif y b_1" data-seat="B-1" data-number="4" data-type="table">4</div>
<div class="@if($result['B-2'] == NULL)seat @endif y b_2" data-seat="B-2" data-number="4" data-type="table">4</div>
<div class="@if($result['C-1'] == NULL)seat @endif x c_1" data-seat="C-1" data-number="4" data-type="table">4</div>
<div class="@if($result['C-2'] == NULL)seat @endif x c_2" data-seat="C-2" data-number="4" data-type="table">4</div>
<div class="@if($result['C-3'] == NULL)seat @endif x c_3" data-seat="C-3" data-number="4" data-type="table">4</div>
<div class="@if($result['D-1'] == NULL)seat @endif z d_1" data-seat="D-1" data-number="1" data-type="counter">１</div>
<div class="@if($result['D-2'] == NULL)seat @endif z d_2" data-seat="D-2" data-number="1" data-type="counter">１</div>
<div class="@if($result['D-3'] == NULL)seat @endif z d_3" data-seat="D-3" data-number="1" data-type="counter">１</div>
<div class="@if($result['D-4'] == NULL)seat @endif z d_4" data-seat="D-4" data-number="1" data-type="counter">１</div>
<div class="@if($result['D-5'] == NULL)seat @endif z d_5" data-seat="D-5" data-number="1" data-type="counter">１</div>

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