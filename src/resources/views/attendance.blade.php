@extends('layouts.app')
<style>
  svg.w-5.h-5 {
    /*paginateメソッドの矢印の大きさ調整のために追加*/
    width: 30px;
    height: 30px;
  }
</style>

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<body>
<h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">
  {{$date}}の勤務一覧
</h1>
<form method="get">
  <input id="atte" class="search-form__date" type="date" name="date" value="{{request('date')}}">
  <input type="submit" value="変更">
</form>

<div class="attendance">
  <table class="attendance__table">
      <tr class="attendance__row">
        <th class="attendance__label">名前</th>
        <th class="attendance__label">勤務開始</th>
        <th class="attendance__label">勤務終了</th>
        <th class="attendance__label">休憩時間</th>
        <th class="attendance__label">勤務時間</th>
      </tr>
    @foreach ($data as $workData)
    <tr class="attendance__row">
        <td class="attendance__data">{{$workData->getName()}}</td>

        <td class="attendance__data">{{$workData->work_start}}</td>
        
        <td class="attendance__data">{{$workData->work_end}}</td>

        <td class="attendance__data">{{$workData->getResttime()}}</td>

        <td class="attendance__data">{{$workData->work_total()}}</td>

    </tr>

    <div class="modal" id="{{$workData->id}}">
        <a href="#!" class="modal-overlay"></a>
        <div class="modal__inner">
          <div class="modal__content">
            <form class="modal__detail-form" action="/delete" method="post">
              @csrf
              <div class="modal-form__group">
                <label class="modal-form__label" for="">名前</label>
                <p>{{$workData->getName()}}</p>
              </div>

              <div class="modal-form__group">
                <label class="modal-form__label" for="">勤務開始</label>
                <p>{{$workData->work_start}}</p>
              </div>

              <div class="modal-form__group">
                <label class="modal-form__label" for="">勤務終了</label>
                <p>{{$workData->work_end}}</p>
              </div>

              <div class="modal-form__group">
                <label class="modal-form__label" for="">休憩時間</label>
                <p>{{$workData->getResttime()}}</p>
              </div>

              <div class="modal-form__group">
                <label class="modal-form__label" for="">勤務時間</label>
                <p>{{$workData->work_total()}}</p>
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
  <div class="d-flex justify-content-center">{{ $data->links() }}</div>
</body>
@endsection
