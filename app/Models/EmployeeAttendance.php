<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeAttendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'employe_id',
        'action',
        'arrive_time',
        "leave_time",
    ];
    /**
     * Get the user that owns the EmployeeAttendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employe()
    {
        return $this->belongsTo(Employee::class);
    }
}
