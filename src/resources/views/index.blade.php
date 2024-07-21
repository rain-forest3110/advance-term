@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection
<body>
@section('content')
<div class="attendance__alert">
  <?php $user = Auth::user(); ?>{{ $user->name }}さんお疲れ様です！
</div>

<div class="attendance__content">
  <div class="attendance__panel">
    <div class="attendance__panel--work">
    <form class="attendance__button">
      <button class="attendance__button-submit" type="submit">勤務開始</button>
    </form>
    <form class="attendance__button">
      <button class="attendance__button-submit" type="submit">勤務終了</button>
    </form>
    </div>
    <div class="attendance__panel--rest">
    <form class="attendance__button">
      <button class="attendance__button-submit" type="submit">休憩開始</button>
    </form>
    <form class="attendance__button">
      <button class="attendance__button-submit" type="submit">休憩終了</button>
    </form>
    </div>
  </div>
</div>
</body>
{{ $users->links('vendor.pagination.default') }}
@endsection
