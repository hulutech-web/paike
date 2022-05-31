<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Schedule;
class Classroom extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

}
