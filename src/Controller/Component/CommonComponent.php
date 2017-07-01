<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\Email;
use Cake\Core\App;

class CommonComponent extends Component
{
    public $components = array('Session');
    
    public function calculatePenalty($rdDataArray,$rdPaymentDataArray)
    {
        $today = date("Y-m-d");
        $penalty = null;

//        $lastPaymentDate = date_parse_from_format("m-d-Y",date('d-m-Y',strtotime($rdPaymentDataArray['created_date'])));
        $lastPaymentDate = date_parse_from_format("Y-m-d",$rdPaymentDataArray['created_date']->format("Y-m-d"));
        $todayDate = date_parse_from_format("Y-m-d",$today);
        $diffMonth = $todayDate['month'] - $lastPaymentDate['month'];
        $diffYear = $todayDate['year'] - $lastPaymentDate['year'];

//        debug($lastPaymentDate);
//        debug($todayDate);
//        debug($diffYear);
//        debug($diffMonth);

        if($diffYear >= 1)
        {
//            debug("here1");
            $diffMonth = $diffYear*12 + $diffMonth;
            if($todayDate['day'] > 20)
            {
                $penalty = 0.1 * $rdDataArray['rd_amount']*$diffMonth;
            }
            else
            {
                $diffMonth -= 1;
                $penalty = 0.1 * $rdDataArray['rd_amount']*$diffMonth;
            }

//            if($todayDate['day'] > 20)
//                $penalty = 0.1 * $rdDataArray['rd_amount'];
//            else
//                $penalty = 0;
        }
        else if($diffYear == 0 && $diffMonth > 0)
        {
//            debug("here2");
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
        else
        {
            $penalty = -1;
        }
//        else if($diffMonth > 1)
//        {
//            if($todayDate['day'] > 20)
//            {
//                $penalty = 0.1 * $rdDataArray['rd_amount']*$diffMonth;
//            }
//            else
//            {
//                $diffMonth -= 1;
//                $penalty = 0.1 * $rdDataArray['rd_amount']*$diffMonth;
//            }
//        }

//        $penalty = 0.1 * ($clientRdData[0]['rd_amount']*pow((1+($clientRdData[0]['rate_of_interest']/100)),$diffMonth));


        return $penalty;

    }

}