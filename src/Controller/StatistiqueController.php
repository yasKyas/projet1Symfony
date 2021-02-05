<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\VoitureType;
use App\Entity\User ;
use App\Entity\Facture;
use App\Entity\Agence;
use App\Entity\Contrat;



class StatistiqueController extends AbstractController
{
    /**
     * @Route("/statistique", name="statistique")
      * @IsGranted("ROLE_AGENT")
     */
    public function affichier(): response
    {
        $voitures =$this->getDoctrine()->getRepository(Voiture::class)->findAll();
        $users =$this->getDoctrine()->getRepository(User::class)->findAll();
        $factures =$this->getDoctrine()->getRepository(Facture::class)->findAll();
        $agences =$this->getDoctrine()->getRepository(Agence::class)->findAll();
        $contrats =$this->getDoctrine()->getRepository(Contrat::class)->findAll();
        return $this->render('statistique/index.html.twig',[
       'voitures' => $voitures,
       'users' => $users,
       'factures' => $factures,
       'agences' => $agences,
       'contrats' => $contrats
       ]);

    }
}