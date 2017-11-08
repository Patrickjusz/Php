<?php

namespace My\KilometrowkaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use My\KilometrowkaBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use My\KilometrowkaBundle\Utils\Stawka;
use My\KilometrowkaBundle\Utils\Logowanie;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('MyKilometrowkaBundle:Default:index.html.twig');
    }

    public function rejestracjaAction(Request $reques) {
        if ($reques->getMethod() == "POST") {
            $em = $this->getDoctrine()->getManager();
            $user = new User();
            $user->setEmail($this->get('request')->request->get('email'));
            $user->setHaslo($this->get('request')->request->get('haslo'));
            $user->setLogin($this->get('request')->request->get('login'));
            $user->setZalogowany(0);
            $em->persist($user);
            $em->flush();
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie', array('blad' => 1)));
        }


        return $this->render('MyKilometrowkaBundle:Default:rejestracja.html.twig');
    }

    public function logowanieAction(Request $reques) {


        if ($reques->getMethod() == "POST") {
            $login = $this->get('request')->request->get('login');
            $haslo = $this->get('request')->request->get('haslo');


            $user = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:User')->findBy(array('login' => $login, 'haslo' => $haslo));



            if (count($user) > 0) {
                $user[0]->setZalogowany(true);
                $user[0]->setHaslo('');
                //zwrocono wynik wiec zalogowona
                $session = new Session();
                $session->start();
                $session->set('user', $user);

//                return $this->render('MyKilometrowkaBundle:Default:logowanie.html.twig', array('user' => $user));
                return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_ewidencja'));
            } else {
                //nie ma takiego usera
                return $this->render('MyKilometrowkaBundle:Default:logowanie.html.twig', array('logowanie' => 1));
            }
        }

        return $this->render('MyKilometrowkaBundle:Default:logowanie.html.twig');
    }

    public function infoAction() {
        $session = $this->getRequest()->getSession();
        $user = $session->get('user');
        $stawka = new Stawka();
        return $this->render('MyKilometrowkaBundle:Default:info.html.twig', array('user' => $user, 'stawka' => $stawka));
    }

    public function wylogujAction(Request $reques) {
        $session = $this->getRequest()->getSession();
        if ($session->has('user')) {
            $session->clear();
            $session->invalidate();
        }
        return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
    }

}
