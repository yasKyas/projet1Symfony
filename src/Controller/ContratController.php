<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Voiture;
use App\Form\ContratType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\ContratRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contrat")
 *  *@IsGranted("ROLE_AGENT")
 */
class ContratController extends AbstractController
{
    /**
     * @Route("/", name="contrat_index", methods={"GET"})
     */
    public function index(ContratRepository $contratRepository): Response
    {
        return $this->render('contrat/index.html.twig', [
            'contrats' => $contratRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contrat_nouveau", methods={"GET","POST"})
     * *@IsGranted("ROLE_AGENT")
     */
    public function new(Request $request): Response
    {
        $contrat = new Contrat();
        $contrat->setDatedepart(new\DateTime('now'));
        $contrat->setDateretour(new\DateTime('tomorrow'));
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date1=$contrat->getDateretour();
            $date2=$contrat->getDatedepart();
            
            $nbJours = $date2->diff($date1)->days;
            if($nbJours>=1 && $date1>$date2){
            $voiture=$this->getDoctrine()->getRepository(Voiture::class)->find($contrat->getVoiture());
            $voiture->setDisponibilite(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contrat);
            $entityManager->flush();
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('contrat_index');
            }
         $erreur="Attention! La date de retour doit etre superieure à la date de debut.( La période doit etre minimum de 1 jour)";
        return $this->render('contrat/newerreur.html.twig', [
            'contrat' => $contrat,
            'form' => $form->createView(),
            'error'=>$erreur,
            'nbjours'=>$nbJours,
        ]);
        }

        return $this->render('contrat/nouveau.html.twig', [
            'contrat' => $contrat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contrat_show", methods={"GET"})
     * *@IsGranted("ROLE_AGENT")
     */
    public function show(Contrat $contrat): Response
    {
        return $this->render('contrat/show.html.twig', [
            'contrat' => $contrat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contrat_edit", methods={"GET","POST"})
     * *@IsGranted("ROLE_AGENT")
     */
    public function edit(Request $request, Contrat $contrat): Response
    {
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voiture');
        }

        return $this->render('contrat/edit.html.twig', [
            'contrat' => $contrat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contrat_delete", methods={"DELETE"})
     * *@IsGranted("ROLE_AGENT")
     */
    public function delete(Request $request, Contrat $contrat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contrat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contrat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('voiture');
    }
}
