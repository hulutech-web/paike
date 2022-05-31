<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classroom;

class Schedule extends Model
{
    use HasFactory;

    public $guarded=['course','classroom','teacher'];

    public  function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }

}
