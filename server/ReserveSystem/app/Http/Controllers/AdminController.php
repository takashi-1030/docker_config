<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\SendMailController;
use App\Models\Reserve;
use App\Models\ReserveSeat;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\AdminUser;
use Validator;

class AdminController extends Controller
{
    public function getIndex()
    {
        $record = Reserve::where('ok_flg',null)->get();

        return view('admin/admin')->with('list',$record);
    }

    public function getReserve($id)
    {
        $record = Reserve::find($id);
        $reserve_seats = ReserveSeat::where('reserve_id',$id)->get();

        return view('admin/reserve')->with([
            'record' => $record,
            'seats' => $reserve_seats
        ]);
    }

    public function reserveEdit($id)
    {
        $record = Reserve::find($id);
        $reserve_seats = ReserveSeat::where('reserve_id',$id)->get();
        $schedule = Schedule::all();

        return view('admin/edit/edit')->with([
            'record' => $record,
            'seats' => $reserve_seats,
            'schedule' => $schedule
        ]);
    }

    public function editCheck(Request $request,$id)
    {
        $input = $request->all() + ['id' => $id];

        $rule = [
            'number' => 'required|numeric',
        ];
        Validator::make($input,$rule)->validate();

        return view('admin/edit/check')->with('input',$input);
    }

    public function editDone(Request $request,$id)
    {
        $request->session()->regenerateToken();
        $reserve = new ReserveController;
        $reserve_record = Reserve::find($id);
        $seats_record = ReserveSeat::where('reserve_id',$id)->get();
        $delete_schedule = $this->deleteSchedule($reserve_record,$seats_record);

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
            $date = $reserve_record->date;
            $start = $reserve_record->time;
            $reserve_seat = $request->old_seat;
            $create_seat = $reserve->create_seat($date,$start,$reserve_seat);

            return view('error/admin_reserve_error');
        } else {
            $name = $reserve_record->name;
            $date = $request->date_str;
            $start = $request->time;
            $reserve_seat = $request->seat;
            foreach($seats_record as $seat_record){
                $seat_record->delete();
            }
            $reserve_record->date = $date;
            $reserve_record->time = $start;
            $reserve_record->number = $request->number;
            $reserve_record->save();
            $create_reserve_seat = $reserve->create_reserve_seat($request,$id);
            $create_seat = $reserve->create_seat($date,$start,$reserve_seat);
            if($reserve_record->email != NULL){
                $send_mail = new SendMailController;
                $send_mail_create = $send_mail->editNotification($request,$name);
            }

            return redirect()->action('AdminController@getIndex');
        }
    }

    public function addReserve(Request $request)
    {
        $date = $request->all();
        $schedule = Schedule::all();

        return view('admin/add/add')->with([
            'date' => $date,
            'schedule' => $schedule
        ]);
    }

    public function reserveCheck(Request $request)
    {
        $input = $request->all();

        $rules = [
            'name' => 'required|string',
            'tel' => 'required|numeric',
            'number' => 'required|numeric',
        ];
        Validator::make($input,$rules)->validate();

        return view('admin/add/check')->with('input',$input);
    }
    public function addDone(Request $request)
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
            return view('error/admin_reserve_error');
        } else {
            $date = $request->date_str;
            $start = $request->time;
            $reserve_seat = $request->seat;

            $reserve = new ReserveController;
            $reserve_record = new Reserve;
            $reserve_record->name = $request->name;
            $reserve_record->tel = $request->tel;
            $reserve_record->date = $date;
            $reserve_record->time = $start;
            $reserve_record->number = $request->number;
            $reserve_record->ok_flg = 'OK';
            $reserve_record->save();
            $id = $reserve_record->id;
            $create_reserve_seat = $reserve->create_reserve_seat($request,$id);
            $create_seat = $reserve->create_seat($date,$start,$reserve_seat);

            return redirect()->action('AdminController@getIndex');
        }
    }

    public function delete($id)
    {
        $reserve_record = Reserve::find($id);
        $seats_record = ReserveSeat::where('reserve_id',$id)->get();
        $delete_schedule = $this->deleteSchedule($reserve_record,$seats_record);
        $reserve_record->delete();

        return redirect()->action('AdminController@getIndex');
    }

    public function deleteSchedule($reserve_record,$seats_record)
    {
        $date = $reserve_record->date;
        $start = $reserve_record->time;
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
        $seats = array();
        foreach($seats_record as $seat_record){
            $seats[] = $seat_record['seat'];
        }

        foreach($seats as $seat){
            $start_record->$seat = NULL;
            $start_record->save();
            $while_record1->$seat = NULL;
            $while_record1->save();
            $while_record2->$seat = NULL;
            $while_record2->save();
            $end_record->$seat = NULL;
            $end_record->save();
            if($margin_record1->$seat == '予約不可'){
                $margin_record1->$seat = NULL;
                $margin_record1->save();
            }
            if($margin_record2->$seat == '予約不可'){
                $margin_record2->$seat = NULL;
                $margin_record2->save();
            }
            if($margin_record3->$seat == '予約不可'){
                $margin_record3->$seat = NULL;
                $margin_record3->save();
            }
        }
    }

    public function reserveConfirm($id)
    {
        $reserve_record = Reserve::find($id);
        $reserve_record->ok_flg = 'OK';
        $reserve_record->save();
        $send_mail = new SendMailController;
        $send_mail_create = $send_mail->confirmNotification($reserve_record);

        return redirect()->action('AdminController@getIndex');
    }

    public function reserveReject($id)
    {
        $reserve_record = Reserve::find($id);
        $seats_record = ReserveSeat::where('reserve_id',$id)->get();
        $delete_schedule = $this->deleteSchedule($reserve_record,$seats_record);
        $send_mail = new SendMailController;
        $send_mail_create = $send_mail->rejectNotification($reserve_record);
        $reserve_record->delete();

        return redirect()->action('AdminController@getIndex');
    }

    public function config()
    {
        return view('admin/config');
    }

    public function configTime(Request $request)
    {
        $input = $request->all();

        $rules = [
            'start_g' => 'required',
            'start_i' => 'required',
            'end_g' => 'required',
            'end_i' => 'required',
        ];
        Validator::make($input,$rules)->validate();

        $start_time = $request->start_g.':'.$request->start_i;
        $end_time = $request->end_g.':'.$request->end_i;
        $start = date('G:i',strtotime($start_time));
        $end = date('G:i',strtotime($end_time));

        $schedule = Schedule::all();
        foreach($schedule as $time){
            $time->delete();
        }

        while($end >= $start){
            $new_schedule = new Schedule;
            $new_schedule->time = $start;
            $new_schedule->save();
            $plus30 = strtotime('+ 30 minute',strtotime($start));
            $start = date('G:i',$plus30);
        }

        return redirect()->action('AdminController@config');
    }

    public function editAjax(Request $request)
    {
        $date = $request->date;
        $old_date = $request->old_date;
        $time = $request->time;
        $seats = $request->seat;
        $after_seats = $request->after_seats;
        if(empty($after_seats)){
            $after_seats = array();
        }

        $result = Seat::where([
            ['date',$date],
            ['time',$time]
        ])->first();

        $start = $request->old_time;
        $plus30 = strtotime('+ 30 minute',strtotime($start));
        $plus60 = strtotime('+ 60 minute',strtotime($start));
        $plus90 = strtotime('+ 90 minute',strtotime($start));
        $plus120 = strtotime('+ 120 minute',strtotime($start));
        $minus30 = strtotime('- 30 minute',strtotime($start));
        $minus60 = strtotime('- 60 minute',strtotime($start));
        $minus90 = strtotime('- 90 minute',strtotime($start));
        $while1 = date('G:i',$plus30);
        $while2 = date('G:i',$plus60);
        $end = date('G:i',$plus90);
        $end_after = date('G:i',$plus120);
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
        $end_after_record = Seat::where([
            ['date',$date],
            ['time',$end_after]
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

        foreach($seats as $seat){
            if($start_record->$seat == '予約済'){
                $old_times[] = $start_record->time;
            }
            if(empty($end_after_record)){
                if($while_record1->$seat == '予約済'){
                    $old_times[] = $while_record1->time;
                }
                if($while_record2->$seat == '予約済'){
                    $old_times[] = $while_record2->time;
                }
                if($end_record->$seat == '予約済'){
                    $old_times[] = $end_record->time;
                }
            } elseif($end_after_record->$seat != '予約済'){
                if($while_record1->$seat == '予約済'){
                    $old_times[] = $while_record1->time;
                }
                if($while_record2->$seat == '予約済'){
                    $old_times[] = $while_record2->time;
                }
                if($end_record->$seat == '予約済'){
                    $old_times[] = $end_record->time;
                }
            }
            if($margin_record1->$seat == '予約不可'){
                $old_times[] = $margin_record1->time;
            }
            if($margin_record2->$seat == '予約不可'){
                $old_times[] = $margin_record2->time;
            }
            if($margin_record3->$seat == '予約不可'){
                $old_times[] = $margin_record3->time;
            }
            $old_times_array[$seat] = $old_times;
        }

        $view = view('admin/edit/ajax')->with([
            'result' => $result,
            'seats' => $seats,
            'after_seats' => $after_seats,
            'old_date' => $old_date,
            'old_times' => $old_times_array
        ]);
        $view = $view->render();

        return $view;
    }

    public function addAjax(Request $request)
    {
        $date = $request->date;
        $time = $request->time;

        $result = Seat::where([
            ['date',$date],
            ['time',$time]
        ])->first();

        $view = view('admin/add/ajax')->with('result',$result);
        $view = $view->render();

        return $view;
    }

//管理者ログイン
    public function adminGetIndex()
    {
        return view('admin/login/login');
    }

    public function adminPostIndex(Request $request)
    {
        return view('admin/login/result');
    }
//管理者登録・削除・一覧画面
    public function adminList()
    {
        $db_result = AdminUser::all();
        return view('admin/list/adminList')->with('adminList', $db_result);
    }

    public function adminCreate()
    {
        return view('admin/adminCreate/input');
    }

    public function adminCreateCheck(Request $request)
    {
        //リクエストパラメータを配列として全件取得
        $input = $request->all();

        //validation
        $rules = [
            'admin_id' => 'required|regex:/^[a-zA-Z0-9-]+$/',
            'password' => 'required|string|min:6',
            'name' => 'required|string',
            'tel' => 'required|regex:/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/',
            'email' => 'required|email',
        ];
        $error_msg = [
            'required' => ':attributeは必須入力です。'
        ];
        Validator::make($input, $rules, $error_msg)->validate();

        $this->validate($request, $rules);

        return view('admin/adminCreate/check')->with('input', $request->all());
    }

    public function adminCreateDone(Request $request)
    {
        $admin_record = new AdminUser;
        $admin_record->admin_id = $request->admin_id;
        $admin_record->name = $request->name;
        $admin_record->password = $request->password;
        $admin_record->tel = $request->tel;
        $admin_record->email = $request->email;
        $admin_record->save();

            return redirect()->action('AdminController@adminList');
    }

    public function adminDelete($id)
    {
        $disp_data = AdminUser::find($id);
        return view('Admin/adminDelete/check')->with('data', $disp_data);
    }

    public function adminDeleteDone($id)
    {
        $delete_user = AdminUser::find($id);
        $delete_user->delete();
        return redirect()->action('AdminController@adminList');
    }

    //お客様一覧

    public function customerList()
    {
        $customer = Reserve::select('name','tel','email')->distinct()->get();
        return view('admin/customer/customerList')->with('customerList', $customer);
    }
    //検索

    public function search()
    {
        return view('admin/search/search');
    }

    public function searchDone(Request $request)
    {
        $date = $request->date;
        $name = $request->name;
        $query = Reserve::query();

        if(!empty($date)){
            $query->where('date',$date)->get();
        }

        if(!empty($name)){
            $query->where('name','like','%'.$name.'%')->get();
        }

        $record = $query->get();

        return view('admin/search/done')->with('record',$record);
    }
}