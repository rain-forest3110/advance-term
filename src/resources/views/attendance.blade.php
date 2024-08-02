@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')


<div class="attendance">
  <table class="attendance__table">
      <tr class="attendance__row">
        <th class="attendance__label">出勤</th>
        <th class="attendance__label">退勤</th>
      </tr>
    @foreach ($data as $workData)
    <tr class="attendance__row">
        <td class="attendance__data">{{$workData->work_start}}</td>
        
        <td class="attendance__data">{{$workData->work_end}}</td>
    </tr>

    <div class="modal" id="{{$workData->id}}">
        <a href="#!" class="modal-overlay"></a>
        <div class="modal__inner">
          <div class="modal__content">
            <form class="modal__detail-form" action="/delete" method="post">
              @csrf
              <div class="modal-form__group">
                <label class="modal-form__label" for="">出勤</label>
                <p>{{$workData->work_start}}</p>
              </div>

              <div class="modal-form__group">
                <label class="modal-form__label" for="">退勤</label>
                <p>{{$workData->work_end}}</p>
              </div>

              <input type="hidden" name="id" value="{{ $workData->id }}">
              <input class="modal-form__delete-btn btn" type="submit" value="削除">

            </form>
          </div>

          <a href="#" class="modal__close-btn">×</a>
        </div>
      </div>
    @endforeach
  </table>
  </div>
@endsection
