<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = ['name', 'days_per_year', 'description', 'status'];

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
