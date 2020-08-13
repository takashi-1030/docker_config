@extends('layout/layout')
@section('library')
<link href="{{ asset('calendar/packages/core/main.css') }}" rel='stylesheet' />
<link href="{{ asset('calendar/packages/daygrid/main.css') }}" rel='stylesheet' />
<link href="{{ asset('calendar/packages/timegrid/main.css') }}" rel='stylesheet' />
<script src="{{ asset('calendar/packages/core/main.js') }}"></script>
<script src="{{ asset('calendar/packages/interaction/main.js') }}"></script>
<script src="{{ asset('calendar/packages/daygrid/main.js') }}"></script>
<script src="{{ asset('calendar/packages/timegrid/main.js') }}"></script>
<script src="{{ asset('calendar/packages/core/locales-all.js') }}"></script>
@stop

@section('styles')
<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
@stop

@section('content')
<h2>予約申し込み</h2>
<div class="panel panel-default">
  <div class="panel-heading"><label>「予約日時」の選択</label></div>
  <div class="panel-body">
    @if($errors->any())
    <div class="alert alert-danger">
      @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
      @endforeach
    </div>
    @endif
    <div id='calendar'></div>
  </div>
</div>

<div class="modal js-modal">
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
      <form action="/reserve_seat" method="post">
        {{ csrf_field() }}
        <div class="modal_head"></div>
        <label>利用人数</label>
        <select name="number" class="form-control" style="width: 100px">
        <option disabled selected value>-</option>
        @for($i = 1;$i <= 8;$i++)
        <option value="{{ $i }}">{{ $i }}名</option>
        @endfor
        </select>
        <br>
        <input type="hidden" name="year" value="" class="year">
        <input type="hidden" name="month" value="" class="month">
        <input type="hidden" name="day" value="" class="day">
        <input type="hidden" name="week" value="" class="week">
        <input type="hidden" name="date_str" value="" class="date_str">
        <input type="submit" value="この日付で予約する" class="btn btn-primary">
        <button class="btn btn-secondary js-modal-close">戻る</button>
      </form>
    </div>
</div>
@stop

@section('script')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
      selectable: true,
      header: {
        left: 'title',
        right: 'prev,next today'
      },
      validRange: function(nowDate) {
        return {
          start: nowDate
        };
      },
      locale: 'ja',
      defaultDate: new Date(),
      fixedWeekCount: false,
      dateClick: function(info) {
        var year = info.date.getFullYear();
        var month = info.date.getMonth() + 1;
        var day = info.date.getDate();
        switch(info.date.getDay()) {
          case 0:
            var week = '日';
            break;
          case 1:
            var week = '月';
            break;
          case 2:
            var week = '火';
            break;
          case 3:
            var week = '水';
            break;
          case 4:
            var week = '木';
            break;
          case 5:
            var week = '金';
            break;
          case 6:
            var week = '土';
            break;
        }
        var str = info.dateStr;
        $('.modal_head').html('<h2>' + year + '年' + month + '月' + day + '日（' + week + '）');
        $('.year').val(year);
        $('.month').val(month);
        $('.day').val(day);
        $('.week').val(week);
        $('.date_str').val(str);
        $('.js-modal').fadeIn();
      },
    });

    calendar.render();
  });

  $(function(){
    $('.js-modal-close').on('click',function(){
        $('.js-modal').fadeOut();
        return false;
    });
  });

</script>
@stop