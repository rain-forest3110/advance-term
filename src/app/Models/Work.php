<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'work_start',
        'work_end'
    ];

    public function getName(){
        return optional($this->user)->name;
    }

    public function getResttime(){
//        return optional($this->rest)->rest_total;
        $total = null;
        foreach($this->rests as $rest) {
            if($total == null) {
                $total = strtotime($rest->rest_end) - strtotime($rest->rest_start);
            }
            else {
                $total += strtotime($rest->rest_end) - strtotime($rest->rest_start);
            }
        }
        return gmdate('H:i:s', $total);
    }
    
    public function work_total()
    {
        $total = null;
        foreach($this->rests as $rest) {
            if($total == null) {
                $total = strtotime($rest->rest_end) - strtotime($rest->rest_start);
            }
            else {
                $total += strtotime($rest->rest_end) - strtotime($rest->rest_start);
            }
        }
        return gmdate('H:i:s', strtotime($this->work_end) - strtotime($this->work_start) - $total);
    }

    protected $table = 'works';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rests()
    {
        return $this->hasMany(Rest::class);
    }

/*    public function getData(){
        $data = DB::table($this->table)->get();
        return $data;
    }*/
}
