<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\VoitureType;
use Symfony\Component\HttpFoundation\Request;

class VoitureController extends AbstractController
{
    /**
     * @Route("/crv", name="create_voiture")
     */
    public function CreateVoiture(Request $request): Response
    {

       $voiture = new Voiture() ;
       $form = $this->createForm(VoitureType::class, $voiture);

       $form->handleRequest($request) ;

           if ($form->isSubmitted() )  {

        $voiture->setDisponibilite(1);
        $entityManager = $this->getDoctrine() ->getManager();
        $entityManager->persist($voiture);
        $entityManager->flush();
        
               return $this->redirectionToRoute('voiture');
           
       }

       return $this->render('voiture/ajouter.html.twig' , [
           'form' => $form->createView()
       ]);
        
    }


     /**
     * @Route("/voiture/{mat}", name="voiturebymat")
     */
    public function afficher(String $mat): Response
    {
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule' => $mat));

        return $this->render('voiture/index.html.twig',  [
            'voitures'  => $voitures,

        ]);
        
    }
     /**
     * @Route("/modifiervoiture/{mat}", name="editvoiturebymat")
     */
    public function modifier(String $mat): Response
    {
        $entityManager = $this ->getDoctrine() ->getManager();
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule' => $mat));
        
        if(!$voiture) {
            throw $this->createNotFoundException(
                'Pas de voiture avec la matricule' .$mat 
            );
        }

        $voiture[0] ->setMarque('POLO');

        $entityManager->flush();
  
            return $this->redirectToRoute('voiturebymat', ['mat' => $mat]);

        
        
    }

     /**
     * @Route("/supprimervoiture/{mat}", name="supprimervoiturebymat")
     */
    public function supprimer(String $mat): Response
    {
        $entityManager = $this ->getDoctrine() ->getManager();
        $voiture = $this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule' => $mat));
        
        if(!$voiture) {
            throw $this->createNotFoundException(
                'Pas de voiture avec la matricule' .$mat 
            );
        }

        $entityManager->remove($voiture[0]);
        $entityManager->flush();
  
            return $this->redirectToRoute('voiture');

        
        
    }
}