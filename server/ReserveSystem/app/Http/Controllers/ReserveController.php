<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\Seat;
use Validator;

class ReserveController extends Controller
{
    public function reserveTop()
    {
        return view('reserve/reserve_top');
    }

    public function reserveSeat(Request $request)
    {
        $rule = [
            'number' => 'required'
        ];
        $this->validate($request,$rule);

        $input = $request->all();

        return view('reserve/reserve_seat')->with('input',$input);
    }

    public function postInfo(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'seat' => 'required'
        ]);
        if($validator->fails()) {
            $test = $this->reserveSeat($request);
            return $test;
        }

        $r_info = $request->all();

        return view('reserve/guest_info')->with('r_info',$r_info);
    }

    public function reserveCheck(Request $request)
    {
        $info = $request->all();

        return view('reserve/check')->with('info',$info);
    }

    public function reserveDone(Request $request)
    {
        $reserve_record = new Reserve;
        $reserve_record->name = $request->name;
        $reserve_record->tel = $request->tel;
        $reserve_record->email = $request->email;
        $reserve_record->date = $request->date_str;
        $reserve_record->time = $request->time;
        $reserve_record->number = $request->number;
        $reserve_record->seat = $request->seat;
        $reserve_record->save();
        $create_seat = $this->create_seat($request);

        return view('reserve/reserve_done');
    }

    public function ajax(Request $request)
    {
        $date = $request->date;
        $time = $request->time;

        $result = Seat::where([
            ['date',$date],
            ['time',$time]
        ])->first();

        $view = view('reserve/ajax')->with('result',$result);
        $view = $view->render();

        return $view;
    }

    public function create_seat(Request $request)
    {
        $date = $request->date_str;
        $seat_number = $request->seat;
        $start = $request->time;
        $plus30 = strtotime('+ 30 minute',strtotime($start));
        $plus60 = strtotime('+ 60 minute',strtotime($start));
        $plus90 = strtotime('+ 90 minute',strtotime($start));
        $minus30 = strtotime('- 30 minute',strtotime($start));
        $minus60 = strtotime('- 60 minute',strtotime($start));
        $minus90 = strtotime('- 90 minute',strtotime($start));
        $while1 = date('G:i',$plus30);
        $while2 = date('G:i',$plus60);
        $end = date('G:i',$plus90);
        $margin1 = date('G:i',$minus30);
        $margin2 = date('G:i',$minus60);
        $margin3 = date('G:i',$minus90);
        $start_record = Seat::where([
            ['date',$date],
            ['time',$start]
        ])->first();
        $while_record1 = Seat::where([
            ['date',$date],
            ['time',$while1]
        ])->first();
        $while_record2 = Seat::where([
            ['date',$date],
            ['time',$while2]
        ])->first();
        $end_record = Seat::where([
            ['date',$date],
            ['time',$end]
        ])->first();
        $margin_record1 = Seat::where([
            ['date',$date],
            ['time',$margin1]
        ])->first();
        $margin_record2 = Seat::where([
            ['date',$date],
            ['time',$margin2]
        ])->first();
        $margin_record3 = Seat::where([
            ['date',$date],
            ['time',$margin3]
        ])->first();

        if($start_record != null){
            $start_record->$seat_number = '予約済';
            $start_record->save();
        } else {
            $seat = new Seat;
            $seat->date = $date;
            $seat->time = $start;
            $seat->$seat_number = '予約済';
            $seat->save();
        }

        if($while_record1 != null){
            $while_record1->$seat_number = '予約済';
            $while_record1->save();
        } else {
            $seat = new Seat;
            $seat->date = $date;
            $seat->time = $while1;
            $seat->$seat_number = '予約済';
            $seat->save();
        }

        if($while_record2 != null){
            $while_record2->$seat_number = '予約済';
            $while_record2->save();
        } else {
            $seat = new Seat;
            $seat->date = $date;
            $seat->time = $while2;
            $seat->$seat_number = '予約済';
            $seat->save();
        }

        if($end_record != null){
            $end_record->$seat_number = '予約済';
            $end_record->save();
        } else {
            $seat = new Seat;
            $seat->date = $date;
            $seat->time = $end;
            $seat->$seat_number = '予約済';
            $seat->save();
        }

        if($margin_record1 != null){
            $margin_record1->$seat_number = '予約不可';
            $margin_record1->save();
        } else {
            $seat = new Seat;
            $seat->date = $date;
            $seat->time = $margin1;
            $seat->$seat_number = '予約不可';
            $seat->save();
        }

        if($margin_record2 != null){
            $margin_record2->$seat_number = '予約不可';
            $margin_record2->save();
        } else {
            $seat = new Seat;
            $seat->date = $date;
            $seat->time = $margin2;
            $seat->$seat_number = '予約不可';
            $seat->save();
        }

        if($margin_record3 != null){
            $margin_record3->$seat_number = '予約不可';
            $margin_record3->save();
        } else {
            $seat = new Seat;
            $seat->date = $date;
            $seat->time = $margin3;
            $seat->$seat_number = '予約不可';
            $seat->save();
        }
    }
}
