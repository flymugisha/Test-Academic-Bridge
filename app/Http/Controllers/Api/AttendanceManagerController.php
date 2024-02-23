<?php

namespace App\Http\Controllers\Api;

use PDF;
use App\Jobs\LeaveJob;
use Illuminate\Http\Request;
use App\Models\EmployeeAttendance;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Classes\Services\AttendanceManagerService;
use Carbon\Carbon;

class AttendanceManagerController extends Controller
{
    public function __construct(
        protected AttendanceManagerService $attendanceManagerService
    ) {
    }
    public function AttendanceArrive(Request $request)
    {
        // dd( date('Y-m-d H:i', time()));
        $request->validate(
            [
                "action" => "required|in:A,L",
                "employe_id" => "required|exists:employees,id",
                "arrive_time" => "required|date|after_or_equal:" . date('Y-m-d H:i', time()),
            ]
        );
        $arrive = $this->attendanceManagerService->Arrive($request);
        // return $arrive;
        LeaveJob::dispatch($arrive);
        return response()->json([
            "status" => true,
            "data" => $arrive,
        ], 200);
    }
    public function AttendanceLeave(Request $request, EmployeeAttendance $employeeAttendance)
    {
        $request->validate(
            [
                "action" => "required|in:A,L",
                "leave_time" => "required|date|after:" . $employeeAttendance->arrive_time,
            ]
        );
        $leave = $this->attendanceManagerService->Leave($request, $employeeAttendance);
        LeaveJob::dispatch($employeeAttendance);
        return response()->json([
            "status" => true,
            "data" => $leave,
        ], 200);
    }
    public function attendancePdf()
    {
        $employeeAttendance = EmployeeAttendance::orderBy('id', 'desc')->get();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('attendance.attendancePdf', compact("employeeAttendance"))->setOptions(['defaultFont' => 'sans-serif']);;
        return $pdf->download('test-attendance.pdf');
    }
    public function attendanceCsv()
    {
        $employeeAttendances = EmployeeAttendance::orderBy('id', 'desc')->get();
        $fields = ["ID", "Name", "Arrive Time", "Leave Time"];
        foreach ($employeeAttendances as $employeeAttendance) {
            $details[] = [
                "ID" => $employeeAttendance->id,
                "Name"       => $employeeAttendance->employe->name,
                "Arrive Time"             => $employeeAttendance->arrive_time,
                "Leave Time"              => $employeeAttendance->leave_time,

            ];
        }
        self::download_send_headers();
        return self::array2csv($fields, $details);
    }

    private static function array2csv($fields, array &$array)
    {
        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        //fputcsv($df, array_keys(reset($array)));

        fputcsv($df, array_values($fields));

        foreach ($array as $value) {
            fputcsv($df, $value);
        }
        fclose($df);
        return ob_get_clean();
    }


    private static function download_send_headers()
    {

        $now = Carbon::now();
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename=" . "Report_Attendance.csv");
        header("Pragma: no-cache");
        header("Content-Transfer-Encoding: binary");
    }
}
