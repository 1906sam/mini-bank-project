<?php
/**
 * Created by PhpStorm.
 * User: sagar
 * Date: 6/2/17
 * Time: 11:18 AM
 */

namespace App\View\Helper;

use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Cake\Datasource\ConnectionManager;

class CommonHelper extends Helper
{
    public function calculatePenalty($rdDataArray,$rdPaymentDataArray)
    {
        $today = date("Y-m-d");

        $lastPaymentDate = date_parse_from_format("d-m-Y",$rdPaymentDataArray['created_date']);
        $todayDate = date_parse_from_format("Y-m-d",$today);
        $diffMonth = $todayDate['month'] - $lastPaymentDate['month'];
        if($diffMonth == 1)
        {
            if($todayDate['day'] > 20)
                $penalty = 0.1 * $rdDataArray['rd_amount'];
            else
                $penalty = 0;
        }
        else if($diffMonth > 1)
        {
            if($todayDate['day'] > 20)
            {
                $penalty = 0.1 * $rdDataArray['rd_amount']*$diffMonth;
            }
            else
            {
                $diffMonth -= 1;
                $penalty = 0.1 * $rdDataArray['rd_amount']*$diffMonth;
            }
        }

    }
}