<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class QuestionsController extends Controller
{
    public function loginAction(Request $request)
    {
        
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('AppBundle:Account:login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
    
    public function registerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        
        $accountEntity = new Account();
        
        $form = $this->createRegisterForm($accountEntity);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $passwordEncoder = $this->get('security.password_encoder');
            $password = $passwordEncoder->encodePassword($accountEntity, $accountEntity->gePlainPassword());
            $accountEntity->setPass($password);
            
            $em->persist($accountEntity->getAddress());
            $em->persist($accountEntity);
            $em->flush();
        }
        
        return $this->render('AppBundle:Account:register.html.twig', [
            'form'  => $form->createView()
        ]);
    }
    
    private function createRegisterForm(Account $accountEntity) {
        return $this->createForm(AccountType::class, $accountEntity);
    }
}