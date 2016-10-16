<?php
/**
 * Created by PHP7.
 * User: Oleksandr Serdiuk
 * SSF Framework 1.0
 * Date: 12.10.2016
 * Time: 16:09
 */

namespace App\Http\Controllers\Traits\Import;

trait AdminImportDaysControlTrait
{
    public function actionCountDaysBetweenDate( $start_date, $end_date )
    {
        $startTimeStamp = strtotime( $start_date);
        $endTimeStamp = strtotime( $end_date );

        $timeDiff = abs($endTimeStamp - $startTimeStamp);

        $numberDays = $timeDiff/86400;  // 86400 seconds in one day

        // and convert to integer
        $numberDays = intval($numberDays);

        return $numberDays;
    }

}