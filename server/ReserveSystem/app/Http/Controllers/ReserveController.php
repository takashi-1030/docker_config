<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
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

        return view('reserve/reserve_done');
    }
}
