<?php

namespace App\Jobs;

use App\Mail\ArriveMail;
use Illuminate\Bus\Queueable;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ArriveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public  $attendance;
    public function __construct(EmployeeAttendance $attendance)
    {
        $this->attendance = $attendance;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->attendance->employe->email)
            ->send(new ArriveMail($this->attendance));
    }
}
