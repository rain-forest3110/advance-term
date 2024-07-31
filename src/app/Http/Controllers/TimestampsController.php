<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;

class TimestampsController extends Controller
{
    public function create(Request $request)
    {
        return view('attendance');
    }


    public function index()
    {
        $object = new Work();
        //users テーブルのデータを User Model のgetData メソッド経由で取得する
        $data = $object->getData();
   	    //viewの呼び出し
   	    return view('attendance', ['data' => $data]);
    }


/*    public function work_start()
    {
        $user = Auth::user();

        /**
         * 打刻は1日一回までにしたい 
         * DB
         */
/*        $oldTimestamp = Work::where('user_id', $user->id)->latest()->first();
        if ($oldTimestamp) {
            $oldTimestampWork_start = new Carbon($oldTimestamp->work_start);
            $oldTimestampDay = $oldTimestampWork_start->startOfDay();
        }

        $newTimestampDay = Carbon::today();

        /**
         * 日付を比較する。同日付の出勤打刻で、かつ直前のTimestampの退勤打刻がされていない場合エラーを吐き出す。
         */
/*        if (($oldTimestampDay == $newTimestampDay) && (empty($oldTimestamp->work_end))){
            return redirect()->back()->with('error', 'すでに出勤打刻がされています');
        }

        $timestamp = Work::create([
            'user_id' => $user->id,
            'work_start' => Carbon::now(),
        ]);

        return redirect()->back()->with('my_status', '出勤打刻が完了しました');
    }*/

/*    public function work_start()
    {
        $user = Auth::user();

        /**
         * 打刻は1日一回までにしたい 
         * DB
         */
/*        $oldTimestamp = Work::where('user_id', $user->id)->latest()->first();
        if ($oldTimestamp) {
            $oldTimestampWork_start = new Carbon($oldTimestamp->work_start);
            $oldTimestampDay = $oldTimestampWork_start->startOfDay();
        } else {
            $timestamp = Work::create([
                'user_id' => $user->id,
                'date' => Carbon::now(),
                'work_start' => Carbon::now(),
            ]);
    
            return redirect()->back()->with('my_status', '出勤打刻が完了しました');
        }

        $newTimestampDay = Carbon::today();

        /**
         * 日付を比較する。同日付の出勤打刻で、かつ直前のTimestampの退勤打刻がされていない場合エラーを吐き出す。
         */
/*        if (($oldTimestampDay == $newTimestampDay) && (empty($oldTimestamp->work_end))){
            return redirect()->back()->with('error', 'すでに出勤打刻がされています');
        }

        $timestamp = Work::create([
            'user_id' => $user->id,
            'date' => Carbon::now(),
            'work_start' => Carbon::now(),
        ]);

        return redirect()->back()->with('my_status', '出勤打刻が完了しました');
    }

    public function work_end()
    {
        $user = Auth::user();
        $timestamp = Work::where('user_id', $user->id)->latest()->first();

        if( !empty($timestamp->work_end)) {
            return redirect()->back()->with('error', '既に退勤の打刻がされているか、出勤打刻されていません');
        }
        $timestamp->update([
            'date' => Carbon::now(),
            'work_end' => Carbon::now()
        ]);

        return redirect()->back()->with('my_status', '退勤打刻が完了しました');
    }



    public function rest_start()
    {
        $work = Auth::work();

        /**
         * 打刻は1日一回までにしたい 
         * DB
         */
/*        $oldTimestamp = Rest::where('work_id', $work->id)->latest()->first();
        if ($oldTimestamp->work_start && !$oldTimestamp->work_end && !$oldTimestamp->rest_start) {
        
            $oldTimestamp->update([
                'rest_start' => Carbon::now(),
            ]);
    
            return redirect()->back();
        }

        $newTimestampDay = Carbon::today();

        return redirect()->back();
    }

    public function rest_end()
    {
        $work = Auth::work();
        $timestamp = Rest::where('work_id', $work->id)->latest()->first();

        if($timestamp->rest_start && !$timestamp->rest_end) {
        $timestamp->update([
            'rest_end' => Carbon::now(),
        ]);
        return redirect()->back();
        }
    return redirect()->back();
    }*/



//出勤アクション
public function work_start() {
    // **必要なルール**
    // ・同じ日に2回出勤が押せない(もし打刻されていたらhomeに戻る設定)
    $user = Auth::user();
    $oldtimein = Work::where('user_id',$user->id)->latest()->first();//一番最新のレコードを取得

    $oldDay = '';

    //退勤前に出勤を2度押せない制御
    if($oldtimein) {
        $oldTimeWork_start = new Carbon($oldtimein->work_start);
        $oldDay = $oldTimeWork_start->startOfDay();//最後に登録したwork_startの時刻を00:00:00で代入
    }
    $today = Carbon::today();//当日の日時を00:00:00で代入

    if(($oldDay == $today) && (empty($oldtimein->work_end))) {
        return redirect()->back()->with('message','出勤打刻済みです');
    }

    // 退勤後に再度出勤を押せない制御
    if($oldtimein) {
        $oldTimeWork_end = new Carbon($oldtimein->work_end);
        $oldDay = $oldTimeWork_end->startOfDay();//最後に登録したwork_startの時刻を00:00:00で代入
    }

    if(($oldDay == $today)) {
        return redirect()->back()->with('message','退勤打刻済みです');
    }

    $month = intval($today->month);
    $day = intval($today->day);
    $year = intval($today->year);


    $time = Work::create([
        'user_id' => $user->id,
//        'user_name' =>$user->name,
        'date' => Carbon::now(),
        'work_start' => Carbon::now(),
//        'month' => $month,
//        'day' => $day,
//        'year' => $year,
    ]);

    return redirect()->back();
}

//退勤アクション
public function work_end() {
    //ログインユーザーの最新のレコードを取得
    $user = Auth::user();
    $timeOut = Work::where('user_id',$user->id)->latest()->first();

    //string → datetime型
    $now = new Carbon();
    $work_start = new Carbon($timeOut->work_start);
    $rest_start = new Carbon($timeOut->rest_start);
    $rest_end = new Carbon($timeOut->rest_end);
    //実労時間(Minute)
    $stayTime = $work_start->diffInMinutes($now);
    $restTime = $rest_start-> diffInMinutes($rest_end);
    $workingMinute = $stayTime - $restTime;
    //15分刻み
    $workingHour = ceil($workingMinute / 15) * 0.25;

    //退勤処理がされていない場合のみ退勤処理を実行
    if($timeOut) {
        if(empty($timeOut->work_end)) {
            if($timeOut->rest_start && !$timeOut->rest_end) {
                return redirect()->back()->with('message','休憩終了が打刻されていません');
            } else {
                $timeOut->update([
                    'date' => Carbon::now(),
                    'work_end' => Carbon::now(),
//                    'workTime' => $workingHour
                ]);
                return redirect()->back()->with('message','お疲れ様でした');
            }
        } else {
            $today = new Carbon();
            $day = $today->day;
            $oldWork_end = new Carbon();
            $oldWork_endDay = $oldWork_end->day;
            if ($day == $oldWork_endDay) {
                return redirect()->back()->with('message','退勤済みです');
            } else {
                return redirect()->back()->with('message','出勤打刻をしてください');
            }
        }
    } else {
        return redirect()->back()->with('message','出勤打刻がされていません');
    } 
}

//休憩開始アクション
public function rest_start() {
    $user = Auth::user();
//    $oldtimein = Time::where('user_id',$user->id)->latest()->first();
//    $oldtimein = Rest::where('work_id',$work->id)->latest()->first();
    $oldtimein = Work::where('user_id',$user->id)->latest()->first();
    if($oldtimein->work_start && !$oldtimein->work_end && !$oldtimein->rest_start) {
        $oldtimein->update([
//            'work_id' => $work->id,
            'rest_start' => Carbon::now(),
        ]);
        return redirect()->back();
    }
    return redirect()->back();
}

//休憩終了アクション
public function rest_end() {
    $user = Auth::user();
//    $oldtimein = Time::where('user_id',$user->id)->latest()->first();
//    $oldtimein = Rest::where('work_id',$work->id)->latest()->first();
    $oldtimein = Work::where('user_id',$user->id)->latest()->first();
    if($oldtimein->rest_start && !$oldtimein->rest_end) {
        $oldtimein->update([
//            'work_id' => $work->id,
            'rest_end' => Carbon::now(),
        ]);
        return redirect()->back();
    }
    return redirect()->back();
}





}