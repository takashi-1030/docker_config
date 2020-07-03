<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;

class EventController extends Controller
{
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
