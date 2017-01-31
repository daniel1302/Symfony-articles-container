<?php
namespace AppBundle\Controller;

use AppBundle\Form\AccountEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Account;
use AppBundle\Form\AccountType;

class AccountController extends Controller
{
    public function loginAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('AppBundle:Account:login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $accountEntity = new Account();

        $form = $this->createRegisterForm($accountEntity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $passwordEncoder = $this->get('security.password_encoder');
            $password = $passwordEncoder->encodePassword($accountEntity, $accountEntity->getPlainPassword());
            $accountEntity->setPass($password);

            $em->persist($accountEntity->getAddress());
            $em->persist($accountEntity);
            $em->flush();

            return $this->redirectToRoute('account_register_success');
        }

        return $this->render('AppBundle:Account:register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $accountEntity = $this->getUser();

        $form = $this->createEditForm($accountEntity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!empty($accountEntity->getPlainPassword())) {
                $passwordEncoder = $this->get('security.password_encoder');
                $password = $passwordEncoder->encodePassword($accountEntity, $accountEntity->getPlainPassword());
                $accountEntity->setPass($password);
            }

            $em->flush();

            return $this->redirectToRoute('account_edit');
        }

        return $this->render('AppBundle:Account:edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function registerSuccessAction()
    {
        return $this->render('AppBundle:Account:registerSuccess.html.twig', []);
    }

    private function createRegisterForm(Account $accountEntity)
    {
        return $this->createForm(AccountType::class, $accountEntity);
    }

    private function createEditForm(Account $accountEntity)
    {
        return $this->createForm(AccountEditType::class, $accountEntity);
    }
}
