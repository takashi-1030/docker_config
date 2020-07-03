@extends('layout/simple_page')

@section('title_header', 'ミーティング一覧')

@section('content')
  <div class="container">
    <div class="card table-responsive">
      <div class="card-header">
        <h3 class="card-title">ミーティング一覧
          <a href="#modal_create_meeting" class="btn btn-primary btn-bordered" data-toggle="modal">
            <i class="fa fa-file mr-1"></i>
          </a>
        </h3>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-hover">
          <tr>
            <th>主催者</th>
            <th>議題</th>
            <th>概要</th>
            <th>開室</th>
            <th>参加</th>
          </tr>
          @foreach($items as $item)
          <tr>
            <td>{{$item->create_user->name}}</td>
            <td>{{$item->title}}</td>
            <td>{{$item->description}}</td>
            <td><a href="{{$item->meeting_url}}" class="btn btn-primary" target="_blank">開室</a></td>
            <td><a href="{{$item->join_url}}" class="btn btn-primary" target="_blank">参加</a></td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
  @component('modal')
    @slot('modal_id','modal_create_meeting')
    @slot('modal_title','ミーティング作成')
    @slot('modal_body')
      @include('create')
    @endslot
  @endcomponent
@endsection