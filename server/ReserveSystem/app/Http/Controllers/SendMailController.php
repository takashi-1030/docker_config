<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Notification;
use App\Mail\EditNotification;
use App\Mail\ConfirmNotification;
use App\Mail\RejectNotification;

class SendMailController extends Controller
{
    public function notification(Request $request)
    {
        $name = $request->name;
        $date_str = date('Y年n月j日',strtotime($request->date_str));
        $week = date('w',strtotime($request->date_str));
        $week_str = ['日','月','火','水','木','金','土'];
        $date = $date_str.'('.$week_str[$week].')';
        $start = $request->time;
        $number = $request->number;
        $to = $request->email;
        Mail::to($to)->send(new Notification($name,$date,$start,$number));
    }

    public function editNotification(Request $request,$name)
    {
        $date_str = date('Y年n月j日',strtotime($request->date_str));
        $week = date('w',strtotime($request->date_str));
        $week_str = ['日','月','火','水','木','金','土'];
        $date = $date_str.'('.$week_str[$week].')';
        $start = date('G:i',strtotime($request->time));
        $number = $request->number;
        $to = $request->email;
        Mail::to($to)->send(new EditNotification($name,$date,$start,$number));
    }

    public function confirmNotification($reserve_record)
    {
        $name = $reserve_record->name;
        $date_str = date('Y年n月j日',strtotime($reserve_record->date));
        $week = date('w',strtotime($reserve_record->date));
        $week_str = ['日','月','火','水','木','金','土'];
        $date = $date_str.'('.$week_str[$week].')';
        $start = date('G:i',strtotime($reserve_record->time));
        $number = $reserve_record->number;
        $to = $reserve_record->email;
        Mail::to($to)->send(new ConfirmNotification($name,$date,$start,$number));
    }

    public function rejectNotification($reserve_record)
    {
        $name = $reserve_record->name;
        $to = $reserve_record->email;
        Mail::to($to)->send(new RejectNotification($name));
    }
}
