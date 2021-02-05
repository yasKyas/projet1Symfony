<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Contrat;
use App\Entity\Agence;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class VoitureController extends AbstractController
{
    /**
     * @Route("/voiture", name="voiture")
     */
    public function index(): Response
    {
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
            'users' => $users
        ]);
    }
        /**
     * @Route("/voiture/{mat}", name="voiturebymat")
     */
     public function affiche(string $mat): Response
     {
       $voitures=$this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule' =>$mat));
         return $this->render('voiture/index.html.twig', [
             'voitures' => $voitures,
         ]);
     }
    /**
     * @Route("/createvoiture", name="create_voiture")
     *@IsGranted("ROLE_ADMIN")
     */


    public function createVoiture(Request $request): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        echo ($form->isSubmitted());
        if ($form->isSubmitted()) {
            $voiture->setdisponibilite(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('voiture/ajouter.html.twig', ['form' => $form->createView()]);
    }
    

   /**
     * @Route("/modifiervoiture/{mat}", name="editvoiturebymat")
     * *@IsGranted("ROLE_ADMIN")
     */
     
        public function modifier(Request $request, String $mat): Response
        {
            $entityManager = $this->getDoctrine()->getManager();
            $voitures = $this->getDoctrine()->getRepository(voiture::class)->findBy(array('matricule' => $mat));
            $voiture = $voitures[0];
            if (!$voiture) {
                throw $this->createNotFoundException(
                    'pas de voiture avec la matricule' . $mat
                );
            }
    
            $form = $this->createForm(VoitureType::class, $voiture);
            $form->handleRequest($request);
            echo ($form->isSubmitted());
            if ($form->isSubmitted()) {
                $voiture->setdisponibilite(1);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($voiture);
                $entityManager->flush();
    
                return $this->redirectToRoute('admin');
            }
    
            return $this->render('voiture/modifier.html.twig', ['form' => $form->createView()]);
        }
        
   /**
    *@route("/admin", name="admin")
    *@IsGranted("ROLE_ADMIN")
    */
    public function admin ()
    {
        
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $agences = $this->getDoctrine()->getRepository(Agence::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'voitures' => $voitures,
            'users' => $users,
            'agences'=>$agences,
        ]);
    }
    
     
      /**
     * @Route("/supprimervoiture/{mat}", name="removevoiturebymat")
     * *@IsGranted("ROLE_ADMIN")
     */
     public function supprimervoiture(string $mat): Response
     {
        $entityManager= $this->getDoctrine()->getManager();
       $voitures=$this->getDoctrine()->getRepository(Voiture::class)->findBy(array('matricule' =>$mat));
       if(!$voitures){
           throw $this->createNotFoundException('pas de voiture avec la matricule'.mat);
       }
       $entityManager->remove($voitures[0]);
$entityManager->flush();
return $this->redirectToRoute('admin');
   
     }
     /**
     * @Route("/rendre/{mat}", name="app_rendre")
     * *@IsGranted("ROLE_AGENT")
     */
    public function rendrevoiture(String $mat): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $voitures = $this->getDoctrine()->getRepository(voiture::class)->findBy(array('matricule' => $mat));
            $voiture = $voitures[0];
            $voiture->setDisponibilite(1);
        

        $entityManager->flush();
        return $this->redirectToRoute('voiture');




    }
}
