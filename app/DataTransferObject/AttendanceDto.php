<?php
namespace App\DataTransferObject;
class AttendanceDto{
    public function __construct(
        public readonly string $employe_id,
        // public readonly date $arrive_time,
        // public readonly date $leave_time,
        // public readonly string $status,
    ) {
    }
}
