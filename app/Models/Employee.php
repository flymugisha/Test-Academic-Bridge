<?php

namespace App\Models;

use App\Models\EmployeeAttendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'employeeIdentifier',
        'name',
        'email',
        "phoneNumber",
        'status',
    ];


    /**
     * Get all of the EmployeAttendance for the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function EmployeAttendance()
    {
        return $this->hasMany(EmployeeAttendance::class, 'employe_id', 'id');
    }

}
