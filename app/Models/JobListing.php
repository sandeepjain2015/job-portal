<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $fillable = [
        'title',
        'company_name',
        'description',
        'pay_range',
        'user_id',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
    ];
    public function applicants()
    {
        return $this->belongsToMany(User::class, 'job_user','job_id');
           
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
