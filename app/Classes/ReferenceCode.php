<?php
namespace App\Classes;

use App\Models\Employee;

class ReferenceCode{
    public static function referenceNumber($length = 7)
    {
        $lastOrder = Employee::orderBy("created_at", "desc")->first();
        if ($lastOrder != null) {
            $ref = (int)explode("-",  $lastOrder->employeeIdentifier)[1];
            $zero = $length - strlen($ref);
            return "DUMA-" . str_repeat("0", $zero) . $ref + 1;

        } else {
            $ref = "0000001";
            return "TAB-0000001";
        }
    }
}
