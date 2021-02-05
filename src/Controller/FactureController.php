<?php

namespace App\Controller;
use App\Entity\Client;
use App\Entity\Facture;
use App\Entity\Contrat;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/facture")
 * *@IsGranted("ROLE_AGENT")
 */
class FactureController extends AbstractController
{
    /**
     * @Route("/", name="facture_index", methods={"GET"})
     */
    public function index(FactureRepository $factureRepository): Response
    {
        return $this->render('facture/index.html.twig', [
            'factures' => $factureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="facture_new", methods={"GET","POST"})
     */
    public function new(string $id,Request $request): Response
    {
        $facture = new Facture();
    
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

        $contrats = $this->getDoctrine()->getRepository(Contrat::class)->findBy(array('id' => $id));
            $contrat = $contrats[0];
            
            $date1=$contrat->getDateretour();
            $date2=$contrat->getDatedepart();
            
            $nbJours = $date2->diff($date1)->days;
            $facture->setMontant(100*$nbJours);
            $facture->setPayee(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('facture_index');
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facture_show", methods={"GET"})
     */
    public function show(Facture $facture): Response
    {
        return $this->render('facture/show.html.twig', [
            'facture' => $facture,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="facture_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Facture $facture): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facture_index');
        }

        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facture_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Facture $facture): Response
    {
        if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facture_index');
    }
     /**
     * @Route("/payee/{id}", name="app_payee")
     */
    public function payeefacture(String $id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $factures = $this->getDoctrine()->getRepository(Facture::class)->findBy(array('id' => $id));
            $facture = $factures[0];
            $facture->setPayee(1);
        

        $entityManager->flush();
        return $this->redirectToRoute('facture_index');




    }
    
    
}
