<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\ReserveSeat;
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
        $reserve_seat = ReserveSeat::where('reserve_id',$id)->get();

        return view('admin/reserve')->with([
            'record' => $record,
            'seats' => $reserve_seat
            ]);
    }

    public function reserveEdit($id)
    {
        $record = Reserve::find($id);

        return view('admin/edit/edit')->with(
            'input', [
                'id' => $id,
                'name' => $record->name,
                'tel' => $record->tel,
                'email' => $record->email,
                'date' => $record->date,
                'time' => $record->time,
                'number' => $record->number,
                'seat' => $record->seat,
            ]);
    }

    public function editCheck(Request $request,$id)
    {
        $input = $request->all() + ['id' => $id];
        return view('admin/edit/check')->with('input',$input);
    }

    public function editDone(Request $request,$id)
    {
        $reserve_record = Reserve::find($id);
        $reserve_record->name = $request->name;
        $reserve_record->tel = $request->tel;
        $reserve_record->email = $request->email;
        $reserve_record->date = $request->date;
        $reserve_record->time = $request->time;
        $reserve_record->number = $request->number;
        $reserve_record->seat = $request->seat;
        $reserve_record->save();

        return redirect()->action('AdminController@getIndex');
    }

    public function addReserve(Request $request)
    {
        $date = $request->all();

        return view('admin/add/add')->with('date',$date);
    }

    public function reserveCheck(Request $request)
    {
        $input = $request->all();

        return view('admin/add/check')->with('input',$input);
    }
    public function addDone(Request $request)
    {
        $reserve_record = new Reserve;
        $reserve_record->name = $request->name;
        $reserve_record->tel = $request->tel;
        $reserve_record->email = $request->email;
        $reserve_record->date = $request->date;
        $reserve_record->time = $request->time;
        $reserve_record->number = $request->number;
        $reserve_record->seat = $request->seat;
        $reserve_record->save();

        return redirect()->action('AdminController@getIndex');
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

        return redirect()->action('AdminController@getIndex');
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
        try {
            $db_result = AdminUser::all();
            return view('admin/list/adminList')->with('adminList', $db_result);
        } catch (Exception $e) {
            return view('error');
        }
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
        try {
            $admin_record = new AdminUser;
            $admin_record->admin_id = $request->admin_id;
            $admin_record->name = $request->name;
            $admin_record->password = $request->password;
            $admin_record->tel = $request->tel;
            $admin_record->email = $request->email;
            $admin_record->save();

            return redirect()->action('AdminController@adminList');
        } catch (Exception $e) {
            return view('error');
        }
    }

    public function adminDelete($id)
    {
        try {
            $disp_data = AdminUser::find($id);
            return view('Admin/adminDelete/check')->with('data', $disp_data);
        } catch (Exception $e) {
            return view('error');
        }
    }

    public function adminDeleteDone($id)
    {
        try {
            $delete_user = AdminUser::find($id);
            $delete_user->delete();
            return redirect()->action('AdminController@adminList');
        } catch (Exception $e) {
            return view('error');
        }
    }
    
    //お客様一覧
    
    public function customerList()
    {
        try{
            $customer = Reserve::select('name','tel','email')->distinct()->get();
            return view('admin/customer/customerList')->with('customerList', $customer);
        } catch (Exception $e) {
            return view('error');
        }
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