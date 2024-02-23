<?php

namespace App\Classes\Services;

use App\Models\Employee;
use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;

class AttendanceManagerService
{

    public function Arrive(Request $request)
    {
        $employee = $request->employe_id;
        $arrive_time = $request->arrive_time;
        $leave_time = $request->leave_time;
        $action = $request->action;
        if ($action == "A") {
            $employeeArrive =  EmployeeAttendance::create(
                [
                    "action" => $action,
                    "employe_id" => $employee,
                    "arrive_time" => $arrive_time,
                ]
            );
        } else {
            $message = "Action unkown";
            return [
                "status" => false,
                "message" => $message
            ];
        }
        return $employeeArrive;
    }

    public function Leave(Request $request, EmployeeAttendance $employeeAttendance)
    {
        $leave_time = $request->leave_time;
        $action = $request->action;
        if ($action == "L") {
            $employeeAttendance->update(
                [
                    "action" => $action,
                    "leave_time" => $leave_time
                ]
            );
        } else {
            $message = "Action unkown";
            return [
                "status" => false,
                "message" => $message
            ];
        }
        return $employeeAttendance;
    }
}
