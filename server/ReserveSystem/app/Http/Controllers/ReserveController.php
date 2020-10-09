<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SendMailController;
use App\Models\Reserve;
use App\Models\ReserveSeat;
use App\Models\Schedule;
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

        $input = $request->all();
        $schedule = Schedule::all();

        $rule = [
            'number' => 'required'
        ];
        $error_msg = [
            'required' => '人数を選択して下さい。'
        ];
        Validator::make($input,$rule,$error_msg)->validate();

        return view('reserve/reserve_seat')->with([
            'input' => $input,
            'schedule' => $schedule
        ]);
    }

    public function postInfo(Request $request)
    {
        $r_info = $request->all();

        return view('reserve/guest_info')->with('r_info',$r_info);
    }

    public function reserveCheck(Request $request)
    {
        $info = $request->all();

        $rules = [
            'name' => 'required|string',
            'tel' => 'required|numeric',
            'email' => 'required|email',
        ];
        Validator::make($info,$rules)->validate();

        return view('reserve/check')->with('info',$info);
    }

    public function reserveDone(Request $request)
    {
        $request->session()->regenerateToken();

        $reserve_check = Seat::where([
            ['date',$request->date_str],
            ['time',$request->time]
        ])->first();
        $seats = $request->seat;
        if($reserve_check == NULL){
            $reserve_check_array = array();
        } else {
            foreach($seats as $seat){
                $reserve_check_array[] = $reserve_check->$seat;
            }
        }

        if(in_array('予約済',$reserve_check_array) || in_array('予約不可',$reserve_check_array)){
            return view('error/guest_reserve_error');
        } else {
            $date = $request->date_str;
            $start = $request->time;
            $reserve_seat = $request->seat;

            $reserve_record = new Reserve;
            $reserve_record->name = $request->name;
            $reserve_record->tel = $request->tel;
            $reserve_record->email = $request->email;
            $reserve_record->date = $date;
            $reserve_record->time = $start;
            $reserve_record->number = $request->number;
            $reserve_record->save();
            $id = $reserve_record->id;
            $create_reserve_seat = $this->create_reserve_seat($request,$id);
            $create_seat = $this->create_seat($date,$start,$reserve_seat);
            $send_mail = new SendMailController;
            //$send_mail_create = $send_mail->notification($request);

            return view('reserve/reserve_done');
        }
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

    public function create_reserve_seat(Request $request,$id)
    {
        $seats = $request->seat;
        foreach($seats as $seat){
            $reserve_seat = new ReserveSeat;
            $reserve_seat->seat = $seat;
            $reserve_seat->reserve_id = $id;
            $reserve_seat->save();
        }
    }

    public function create_seat($date,$start,$reserve_seat)
    {
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

        foreach($reserve_seat as $seat_number){
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
                if($margin_record1->$seat_number == null){
                    $margin_record1->$seat_number = '予約不可';
                    $margin_record1->save();
                }
            } else {
                $seat = new Seat;
                $seat->date = $date;
                $seat->time = $margin1;
                $seat->$seat_number = '予約不可';
                $seat->save();
            }

            if($margin_record2 != null){
                if($margin_record2->$seat_number == null){
                    $margin_record2->$seat_number = '予約不可';
                    $margin_record2->save();
                }
            } else {
                $seat = new Seat;
                $seat->date = $date;
                $seat->time = $margin2;
                $seat->$seat_number = '予約不可';
                $seat->save();
            }

            if($margin_record3 != null){
                if($margin_record3->$seat_number == null){
                    $margin_record3->$seat_number = '予約不可';
                    $margin_record3->save();
                }
            } else {
                $seat = new Seat;
                $seat->date = $date;
                $seat->time = $margin3;
                $seat->$seat_number = '予約不可';
                $seat->save();
            }
        }
    }
}
