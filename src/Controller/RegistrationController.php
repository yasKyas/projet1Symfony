<?php

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * *@IsGranted("ROLE_ADMIN")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(["ROLE_AGENT"]);
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )

            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
        /**
     * @Route("/supprimerAgent/{email}", name="removeAgent")
     * *@IsGranted("ROLE_ADMIN")
     */
    public function supprimerAgent(string $email): Response
    {
       $entityManager= $this->getDoctrine()->getManager();
      $users=$this->getDoctrine()->getRepository(User::class)->findBy(array('email'=>$email));
      
      $entityManager->remove($users[0]);
$entityManager->flush();
return $this->redirectToRoute('admin');
  
    }
     /**
    @Route("/rendreAdmin/{email}", name="rendreadmin")
     * *@IsGranted("ROLE_ADMIN")
     */
    public function rendreAdmin(String $email): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $users = $this->getDoctrine()->getRepository(User::class)->findBy(array('email' => $email));
            $user = $users[0];
            $user->setRoles(["ROLE_ADMIN"]);
        

        $entityManager->flush();
        return $this->redirectToRoute('admin');




    }
         /**
    @Route("/rendreAgent/{email}", name="rendreagent")
     * *@IsGranted("ROLE_ADMIN")
     */
    public function rendreAgent(String $email): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $users = $this->getDoctrine()->getRepository(User::class)->findBy(array('email' => $email));
            $user = $users[0];
            $user->setRoles(["ROLE_AGENT"]);
        

        $entityManager->flush();
        return $this->redirectToRoute('admin');




    }
}
