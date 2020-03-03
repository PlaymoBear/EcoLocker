<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Computer;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MachinesController extends AbstractController
{
    /**
     * @Route("/machines", name="machines")
     */

    public function index()
    {
        $repo_computer=$this->getDoctrine()->getRepository(Computer :: class);

        return $this->render('machines/index.html.twig', [
            'controller_name' => 'MachinesController',
        ]);
    }

    /**
     * @Route("/",name="home")
     */

    public function home(AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('machines/home.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
    /**
     * @Route("/inscription", name="security_registration")
     */

    public function registration(Request $request, UserPasswordEncoderInterface $encoder) {
        $manager = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this -> createForm(ResgisterType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setRoles(array('ROLE_USER'));
            $user->setPassword($hash);
            ;

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render("security/registration.html.twig", ['form'=> $form->createView()]);

    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout() {}

    /**
     * @Route("/casier", name="casier")
     */

    public function casier() {
        return $this->render('machines/prendre_casier.html.twig');
    }


}
