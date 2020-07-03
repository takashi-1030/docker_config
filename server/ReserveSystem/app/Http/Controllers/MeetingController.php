<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Builder;
use App\Models\Meetings;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public $api_base_url = 'https://api.zoom.us/v2/';
    public $domain = 'meetings';
    public function model()
    {
        return Meetings::query();
    }

    public function show(Request $request)
    {
        $items = $this->model()->get();

        $params = [
            'items' => $items,
        ];
        return view('list')->with($params);
    }

    public function store(Request $request)
    {
        $meeting = $this->create_meeting($request);
        $form = $this->create_form($meeting);
        $res = $this->model()->create($form);
        return back()->with(['params'=>$res]);
    }

    public function create_form($meeting)
    {
        $user = Auth::user();
        $form = [];
        $form['title'] = $meeting['topic'];
        $form['description'] = $meeting['agenda'];
        $form['meeting_url'] = $meeting['start_url'];
        $form['join_url'] = $meeting['join_url'];
        $form['create_user_id'] = $user->id;
        return $form;
    }

    public function create_access_token()
    {
        $client_key = env('CLIENT_KEY');
        $client_secret = env('CLIENT_SECRET');

        $signer = new Sha256;
        $time = time();
        $token = (new Builder())->issuedBy($client_key)
                                ->expiresAt($time + 3600)
                                ->getToken($signer,new Key($client_secret));

        return $token;
    }

    public function create_meeting(Request $request)
    {
        $method = 'POST';
        $user_id = $this->get_users()['id'];
        $url = '/v2/users/'.$user_id.'/meetings';
        $token = $this->create_access_token();

        $params = [
            'topic' => $request->topic,
            'type' => 1,
            'time_zone' => 'Asia/Tokyo',
            'agenda' => $request->agenda,
            'settings' => [
                'host_video' => false,
                'participant_video' => true,
                'cn_meeting' => false,
                'in_meeting' => false,
                'mute_upon_entry' => false,
                'watermark' => false,
                'use_pmi' => false,
                'approval_type' => 0,
                'registration_type' => 0,
                'audio' => 'both',
                'enforce_login' => false,
                'registrants_email_notification' => false
            ]
        ];
        $client_params = [
            'base_uri' => $this->api_base_url,
            'json' => $params
        ];
        $options = [
            'headers' => [
                'Accept' => 'application/json, application/xml',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ]
        ];
        $res = $this->call_api($url,$client_params,$options,$method);

        return $res;
    }

    public function get_users()
    {
        $method = 'GET';
        $url = 'users';
        $token = $this->create_access_token();

        $client_params = [
            'base_uri' => $this->api_base_url,
        ];
        $options = [
            'headers' => [
                'Accept' => 'application/json, application/xml',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ]
        ];
        $users = $this->call_api($url,$client_params,$options,$method);
        return $users['users'][0];
    }

    public function call_api($url,$client_params,$options,$method)
    {
        $client = new Client($client_params);
        $res = $client->request($method,$url,$options)->getBody()->getContents();
        return json_decode($res,true);
    }
}
