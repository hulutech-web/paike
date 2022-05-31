<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded=['user'];
    protected $casts = [
        'course' => 'array',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function scopeSearch($query, $name)
    {
        if ($name) {
            return $query->where('name', 'LIKE', "%$name%");
        }
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
