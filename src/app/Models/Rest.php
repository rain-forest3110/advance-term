<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'rest_start',
        'rest_end'
    ];

//    protected $guarded = array('id');
//    public static $rules = array(
//        'work_id' => 'required',
//        'rest_start' => 'required',
//        'rest_end' => 'required',
//    );

    public function rest_total()
    {
        return gmdate('H:i:s', strtotime($this->rest_end) - strtotime($this->rest_start));
    }


    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
