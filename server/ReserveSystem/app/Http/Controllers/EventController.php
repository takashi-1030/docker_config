<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\ReserveSeat;
use App\Models\Schedule;

class EventController extends Controller
{
    public function reserveCount(Request $request)
    {
        $start = $this->formatDate($request->all()['start']);
        $end = $this->formatDate($request->all()['end']);

        $schedule_count = Schedule::all()->count();
        $reservable = ($schedule_count - ($schedule_count % 4)) / 4 * 12;
        $reservable_danger = floor($reservable * 0.7);

        $reserve = ReserveSeat::join('reserves','reserve_seats.reserve_id','=','reserves.id')
        ->where('reserves.date','2020-08-31')
        ->count();

        $newArr = [];

        while($start <= $end){
            $reserve_count = ReserveSeat::join('reserves','reserve_seats.reserve_id','=','reserves.id')
                                  ->where('reserves.date',$start)
                                  ->count();
            if($reserve_count >= $reservable_danger){
                $newItem["title"] = '△';
                $newItem["textColor"] = 'red';
            } elseif($reserve_count == $reservable){
                $newItem["title"] = '✕';
                $newItem["textColor"] = 'gray';
            } else {
                $newItem["title"] = '◎';
                $newItem["textColor"] = 'blue';
            }
            $newItem["start"] = $start;
            $newItem["color"] = 'transparent';
            $newItem["display"] = 'none';
            $newArr[] = $newItem;
            $start = date('Y-m-d',strtotime($start.'+1 day'));
        }

        echo json_encode($newArr);
    }

    public function setEvent(Request $request)
    {
        $start = $this->formatDate($request->all()['start']);
        $end = $this->formatDate($request->all()['end']);

        $events = Reserve::select('id','name','date','time','ok_flg')->whereBetween('date',[$start,$end])->get();

        $newArr = [];
        foreach($events as $item){
            $newItem["id"] = $item["id"];
            $newItem["title"] = $item["name"].'様';
            $newItem["start"] = $item["date"].'T'.$item["time"];
            $newItem["end"] = $item["date"].'T'.$item["time"].'+07:00';
            if($item['ok_flg'] == 'OK'){
                $newItem["color"] = 'primary';
            }else{
                $newItem["color"] = 'red';
            }
            $newItem["textColor"] = 'white';
            $newArr[] = $newItem;
        }

        echo json_encode($newArr);
    }

    public function formatDate($date)
    {
        return str_replace('T00:00:00+09:00','',$date);
    }
}
