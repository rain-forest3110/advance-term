@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance__alert">
  <?php $user = Auth::user(); ?>{{ $user->name }}さんお疲れ様です！
</div>

<div class="container">
    @foreach ($itmes ?? '' as $itme)
    <div class="attendance">
      <table>
        <tr><td>出勤</td><td>{{$itme->work_start}}</td></tr>
        <tr><td>休憩開始</td><td>{{$itme->rest_start}}</td></tr>
        <tr><td>休憩終了</td><td>{{$itme->rest_end}}</td></tr>
        <tr><td>退勤</td><td>{{$itme->work_end}}</td></tr>
      </table>
    </div>
    @endforeach
  </div>
@endsection
