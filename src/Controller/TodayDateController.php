<?php 

namespace App\Controller ;
use Symfony\Component\HttpFoundation\Response ;
use Symfony\Component\Routing\Annotation\Route ;


class TodayDateController {

/**
 *   @Route("/today/date", name="today_date")
 */
    public function date()
    {
        $date = date("d/m/Y") ;
        return new Response("<html><body> Today is:' .$date. '</body></html>") ;
    }
}
?>