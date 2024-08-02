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

    

    protected $table = 'works';

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function getData(){
        $itmes = DB::table($this->table)->get();
        return $itmes;
    }
}
