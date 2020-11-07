<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

 


class CurrentHourController extends AbstractController
{

    /**
     * @Route("/current/hour/", name="current-hour")
     */ 

    public function index()
    {
    	 $hour = date("h:i:sa");
         return $this->render('current_hour/index.html.twig', [
            'time' => $hour,
        ]);// retourner la nouvelle template + le nom du controlleur 
    }
}