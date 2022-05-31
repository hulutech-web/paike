<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    protected $fillable = ['name', 'config', 'company_id'];
    protected $casts = [
        'config' => 'json'
    ];

    public function company()
    {
        return $this->belongsToMany(Company::class)->withTimestamps();
    }
}
