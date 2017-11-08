<?php

namespace My\KilometrowkaBundle\Utils;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Session\Session;
use My\KilometrowkaBundle\Entity\User;

class Logowanie {

    public static function czyZalogowano(\Symfony\Component\HttpFoundation\Session\Session $session, Request $reques) {

        if ($session->has('user')) {
            $user = $session->get('user');
            if (!$user[0]->getZalogowany()) {
                return false;
            }
//            var_dump($user);
            return $user;
        } else {
            return false;
        }
    }

}
