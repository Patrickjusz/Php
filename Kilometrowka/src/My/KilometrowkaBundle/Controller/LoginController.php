<?php

namespace My\KilometrowkaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use My\KilometrowkaBundle\Entity\Firma;
use My\KilometrowkaBundle\Entity\Trasa;
use My\KilometrowkaBundle\Entity\Pojazd;
use My\KilometrowkaBundle\Entity\Pracownik;
use My\KilometrowkaBundle\Entity\Przejazd;
use My\KilometrowkaBundle\Utils\Stawka;
use My\KilometrowkaBundle\Utils\Logowanie;

class LoginController extends Controller {

    public function ewidencjaAction(Request $reques) {
        //------------------------------------------------------------------------------------
        if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
        }
        //------------------------------------------------------------------------------------

        $idUzytkownika = $reques->getSession()->get('user');
        $iddd = $idUzytkownika[0]->getId();

        $pobierzDostepnePrzejazdy = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Przejazd')
                ->findBy(array('idUzytkownika' => $iddd));

        $pobierzDostepneFirmy = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Firma')
                ->findBy(array('idUzytkownika' => $iddd));

        if (empty($pobierzDostepneFirmy)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_przejazdy', array('blad' => 4)));
        }




        $listaFirm = array();
        $i = 0;
        foreach ($pobierzDostepneFirmy as $row) {
            $listaFirm[$i] = $row;
            $i++;
        }

        if ($reques->getMethod() == 'POST') {
            $idFirmy = $this->get('request')->request->get('idFirmy');
            $em = $this->getDoctrine()->getEntityManager();
            $query = $em->createQuery("SELECT m.idPojazdu, m.idTrasy, m.idPracownika, m.idFirmy, m.celWyjazdu, m.adnotacje, m.data, m.odlegloscTrasy, m.nazwaPojazdu, m.cena, max(m.data) as maxx, sum(m.odlegloscTrasy) as summ FROM MyKilometrowkaBundle:Przejazd as m WHERE m.idFirmy=" . $idFirmy . " GROUP BY m.idPojazdu");
            $przejazdy = $query->getResult();



            $stawka = new Stawka();
            $stawka->getStawkaDo900();
            $i = 0;
            foreach ($przejazdy as $rows) {
                $idPojazdu = $przejazdy[$i]['idPojazdu'];
                $pojemnoscPojazdu = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pojazd')->find($idPojazdu);

                if ($pojemnoscPojazdu->getPojemnoscSilnika() == 1) {
                    $przejazdy[$i]['cena'] = round($przejazdy[$i]['summ'] * $stawka->getStawkaDo900(), 2);
                }

                if ($pojemnoscPojazdu->getPojemnoscSilnika() == 2) {
                    $przejazdy[$i]['cena'] = round($przejazdy[$i]['summ'] * $stawka->getStawkaPowyzej900(), 2);
                }

                if ($pojemnoscPojazdu->getPojemnoscSilnika() == 3) {
                    $przejazdy[$i]['cena'] = round($przejazdy[$i]['summ'] * $stawka->getStawkaMotocykl(), 2);
                }

                if ($pojemnoscPojazdu->getPojemnoscSilnika() == 4) {
                    $przejazdy[$i]['cena'] = round($przejazdy[$i]['summ'] * $stawka->getStawkaMotorower(), 2);
                }
                $i++;
            }


            $i = 0;
            $dane = array();
            foreach ($przejazdy as $row) {
                $dane[$i]['obiekt'] = $row;
                $query2 = $em->createQuery("SELECT m.miesiacIRok FROM MyKilometrowkaBundle:Przejazd as m where m.idFirmy=" . $row['idFirmy'] . " and m.idPojazdu=" . $row['idPojazdu'] . " group by m.miesiacIRok");
                $daty = $query2->getResult();
                $dane[$i]['miesiace'] = $daty;
                $i++;
            }

            $idFirmySelect = $this->get('request')->request->get('idFirmy');
            return $this->render('MyKilometrowkaBundle:Login:ewidencja.html.twig', array(
                        'firmy' => $listaFirm,
                        'b' => $dane,
                        'idFirmySelect' => $idFirmySelect,
                        'user' => $user
            ));
        }

        $przejazdy = null;
        return $this->render('MyKilometrowkaBundle:Login:ewidencja.html.twig', array(
                    'firmy' => $listaFirm,
                    'b' => $przejazdy,
                    'user' => $user
        ));
    }

    //{idFirmy}/{idPojazdu}/{miesiac}/{rok}
    public function ewidencjaNrAction(Request $reques, $idFirmy, $idPojazdu, $miesiac, $rok, $raport) { {
            //------------------------------------------------------------------------------------
            if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
                return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
            }

            $idUzytkownika = $reques->getSession()->get('user');
            $iddd = $idUzytkownika[0]->getId();

            $pobierzDostepnePrzejazdy = $this->getDoctrine()
                    ->getRepository('MyKilometrowkaBundle:Przejazd')
                    ->findBy(array('idUzytkownika' => $iddd));

            $pobierzDostepneFirmy = $this->getDoctrine()
                    ->getRepository('MyKilometrowkaBundle:Firma')
                    ->findBy(array('idUzytkownika' => $iddd));

            if (empty($pobierzDostepneFirmy)) {
                return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_przejazdy', array('blad' => 4)));
            }
            //------------------------------------------------------------------------------------
            $przejazd = new Przejazd();
            if (is_numeric($idFirmy) && is_numeric($idPojazdu) && is_numeric($miesiac) && is_numeric($rok)) {

                $em = $this->getDoctrine()->getEntityManager();
//             

                $okresDaty = $rok . '-' . $miesiac . '-01';
                $koncowaData = $rok . '-' . $miesiac . '-' . date('t', strtotime($okresDaty));
//                var_dump($koncowaData);
                $query = $em->createQuery("SELECT m.idPojazdu, m.idTrasy, m.idPracownika, m.idFirmy, m.celWyjazdu, m.adnotacje, m.data, m.odlegloscTrasy, m.nazwaPojazdu, m.cena, m.nazwaFirmy, m.nazwaTrasy, m.miesiacIRok, m.nazwaPracownika FROM MyKilometrowkaBundle:Przejazd as m WHERE m.idFirmy=" . $idFirmy . " and m.idPojazdu=" . $idPojazdu . " and m.data>'$okresDaty' and m.data<'$koncowaData'");

                $przejazdy = $query->getResult();
//                var_dump($przejazdy);
                $st = new Stawka();

                $pojazd = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pojazd')->find($idPojazdu);
                $firma = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Firma')->find($idFirmy);
                //--

                $pojemnoscPojazdu = $pojazd;

                if ($pojemnoscPojazdu->getPojemnoscSilnika() == 1) {
                    $stawka = $st->getStawkaDo900();
                    $pojemnoscPojazdu->setPojemnoscSilnika('Samochod os. poj. poniżej 900cm^3');
                }

                if ($pojemnoscPojazdu->getPojemnoscSilnika() == 2) {
                    $stawka = $st->getStawkaPowyzej900();
                    $pojemnoscPojazdu->setPojemnoscSilnika('Samochod os. poj. powyżej 900cm^3');
                }

                if ($pojemnoscPojazdu->getPojemnoscSilnika() == 3) {
                    $stawka = $st->getStawkaMotocykl();
                    $pojemnoscPojazdu->setPojemnoscSilnika('Motocykl');
                }

                if ($pojemnoscPojazdu->getPojemnoscSilnika() == 4) {
                    $pojemnoscPojazdu->setPojemnoscSilnika('Motorower');
                }
                //--

                if ($raport == 1) {

                    $odpowiedz = "";
                    $odpowiedz .= "Firma:" . "\n";
                    $odpowiedz .= " " . $firma->getNazwaFirmy() . "\n";
                    $odpowiedz .= " " . $firma->getNip() . "\n";
                    $odpowiedz .= " " . $firma->getRegon() . "\n\n";

                    $odpowiedz .= "Pojazd:" . "\n";
                    $odpowiedz .= " " . $pojazd->getNazwa() . "\n";
                    $odpowiedz .= " " . $pojazd->getNumerRejestracyjny() . "\n";
                    $odpowiedz .= " " . $pojazd->getPojemnoscSilnika() . "\n\n";

                    $odpowiedz .= "--------------------------------------------------------------------------------\n";
                    $odpowiedz .= "LP | Data | Trasa | Pracownik | Stawka | Przejechane km | Wartość | Cel wyjazdu\n";
                    $odpowiedz .= "--------------------------------------------------------------------------------\n";

                    //--
                    $i = 1;
                    $sumaKm = 0;
                    $sumaZl = 0;
                    $st = new Stawka();
                    foreach ($przejazdy as $przejazd) {
                        $odpowiedz .= strval($i) . " | ";
                        $odpowiedz .= $przejazd['data']->format('Y-m-d') . " | ";
                        $odpowiedz .= $przejazd['nazwaTrasy'] . " | ";
                        $odpowiedz .= $przejazd['nazwaPracownika'] . " | ";

                        if ($przejazd['cena'] == 1) {
                            $stawka = $st->getStawkaDo900();
                            $przejazd['cena'] = $stawka;
                        }

                        if ($przejazd['cena'] == 2) {
                            $stawka = $st->getStawkaPowyzej900();
                            $przejazd['cena'] = $stawka;
                        }

                        if ($przejazd['cena'] == 3) {
                            $stawka = $st->getStawkaMotocykl();
                            $przejazd['cena'] = $stawka;
                        }

                        if ($przejazd['cena'] == 4) {
                            $przejazd['cena'] = $stawka;
                        }


                        $odpowiedz .= $przejazd['cena'] . " | ";
                        $odpowiedz .= $przejazd['odlegloscTrasy'] . "km | ";
                        $odpowiedz .= (($przejazd['cena'] * $przejazd['odlegloscTrasy'] * 100) / 100) . " | ";
                        $odpowiedz .= $przejazd['celWyjazdu'] . "\n";
                        $i++;
                        $sumaZl += ($przejazd['cena'] * $przejazd['odlegloscTrasy']);
                        $sumaKm += $przejazd['odlegloscTrasy'];
                    }
                    $odpowiedz .= "--------------------------------------------------------------------------------\n\n";
                    $odpowiedz .= " [ Suma przejechanych kilometrów: " . $sumaKm . " km ]\n";
                    $odpowiedz .= " [ Wartość w złotówkach: " . round($sumaZl, 2) . " zł ]";


                    return new Response(
                            $odpowiedz, Response::HTTP_OK, array('content-type' => 'text/plain'));
                }


                return $this->render('MyKilometrowkaBundle:Login:ewidencjaNr.html.twig', array(
                            'przejazdy' => $przejazdy,
                            'stawka' => $stawka,
                            'pojazd' => $pojazd,
                            'firma' => $firma,
                            'rok' => $rok,
                            'miesiac' => $miesiac,
                            'user' => $user
                ));
            } else {
                //redirect
                return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_ewidencja'));
            }
        }
        return $this->render('MyKilometrowkaBundle:Login:ewidencjaNr.html.twig');
    }

    public function przejazdyAction(Request $reques) {
//------------------------------------------------------------------------------------
        if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
        }
        //------------------------------------------------------------------------------------

        $idUzytkownika = $reques->getSession()->get('user');
        $iddd = $idUzytkownika[0]->getId();
        $pobierzDostepneFirmy = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Firma')
                ->findBy(array('idUzytkownika' => $iddd));
        $pobierzDostepneTrasy = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Trasa')
                ->findBy(array('idUzytkownika' => $iddd));
        $pobierzDostepnePojazdy = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Pojazd')
                ->findBy(array('idUzytkownika' => $iddd));
        $pobierzDostepnePracownicy = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Pracownik')
                ->findBy(array('idUzytkownika' => $iddd));

        if (empty($pobierzDostepneFirmy)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_firmy', array('blad' => 1)));
        }

        if (empty($pobierzDostepneTrasy)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_trasy', array('blad' => 1)));
        }

        if (empty($pobierzDostepnePojazdy)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_pojazdy', array('blad' => 1)));
        }

        if (empty($pobierzDostepnePracownicy)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_pracownicy', array('blad' => 1)));
        }



        $przejazdy = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Przejazd')
                ->findBy(array('idUzytkownika' => $iddd));

        if (NULL == $przejazdy) {
            //@TODO MUSI BYĆ JEDEN!? CZEMu
            return $this->render('MyKilometrowkaBundle:Login:przejazdy.html.twig', array(
                        'user' => $user
            ));
        }

        //pobieranie po ID nazw 
        foreach ($przejazdy as $row) {
            $idPojazdu = $row->getIdPojazdu();
            $idTrasy = $row->getIdTrasy();
            $idFirmy = $row->getIdFirmy();
            $idPracownika = $row->getIdPracownika();

            $nazwaPojazdu = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pojazd')->find($idPojazdu);
            $nazwaTrasy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Trasa')->find($idTrasy);
            $nazwaFirmy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Firma')->find($idFirmy);
            $nazwaPracownika = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pracownik')->find($idPracownika);

            $row->setNazwaPojazdu($nazwaPojazdu->getNazwa());
            $row->setNazwaTrasy($nazwaTrasy->getNazwa());
            $row->setNazwaFirmy($nazwaFirmy->getNazwaFirmy());
            $row->setNazwaPracownika($nazwaPracownika->getNazwisko());
        }

        return $this->render('MyKilometrowkaBundle:Login:przejazdy.html.twig', array('przejazdy' => $przejazdy, 'user' => $user));
    }

    public function pracownicyAction(Request $reques) {
        //------------------------------------------------------------------------------------
        if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
        }
        //------------------------------------------------------------------------------------

        $idUzytkownika = $reques->getSession()->get('user');
        $iddd = $idUzytkownika[0]->getId();
        $pracownicy = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Pracownik')
                ->findBy(array('idUzytkownika' => $iddd));

        if (NULL == $pracownicy) {
            return $this->render('MyKilometrowkaBundle:Login:pracownicy.html.twig', array(
                        'user' => $user
            ));
        }

        return $this->render('MyKilometrowkaBundle:Login:pracownicy.html.twig', array(
                    'pracownik' => $pracownicy,
                    'user' => $user
        ));
    }

    public function pojazdyAction(Request $reques) {
        //------------------------------------------------------------------------------------
        if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
        }
        //------------------------------------------------------------------------------------

        $idUzytkownika = $reques->getSession()->get('user');
        $iddd = $idUzytkownika[0]->getId();
        $pojazd = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pojazd')->findBy(array('idUzytkownika' => $iddd));

        if (NULL == $pojazd) {
            return $this->render('MyKilometrowkaBundle:Login:pojazdy.html.twig', array(
                        'user' => $user
            ));
        }


        return $this->render('MyKilometrowkaBundle:Login:pojazdy.html.twig', array(
                    'pojazd' => $pojazd,
                    'user' => $user
        ));
    }

    public function trasyAction(Request $reques) {
        //------------------------------------------------------------------------------------
        if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
        }
        //------------------------------------------------------------------------------------

        $idUzytkownika = $reques->getSession()->get('user');
        $iddd = $idUzytkownika[0]->getId();
        $trasy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Trasa')->findBy(array('idUzytkownika' => $iddd));

        if (NULL == $trasy) {
            return $this->render('MyKilometrowkaBundle:Login:trasy.html.twig', array(
                        'trasa' => $trasy,
                        'user' => $user
            ));
        }

        return $this->render('MyKilometrowkaBundle:Login:trasy.html.twig', array('trasa' => $trasy,
                    'user' => $user
        ));
    }

    public function firmyAction(Request $reques) {
        //------------------------------------------------------------------------------------
        if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
        }
        //------------------------------------------------------------------------------------
        $idUzytkownika = $reques->getSession()->get('user');
        $iddd = $idUzytkownika[0]->getId();
        $firmy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Firma')->findBy(array('idUzytkownika' => $iddd));

        if (NULL == $firmy) {
            //throw $this->createNotFoundException('Nie ma takiej firmy!');
        }

        return $this->render('MyKilometrowkaBundle:Login:firmy.html.twig', array(
                    'firma' => $firmy,
                    'user' => $user,
        ));
    }

//@TODO REFAKTORYZACJA TABLIC ARRAY
    public function usunAction(Request $reques, $id, $typ) {
        //------------------------------------------------------------------------------------
        if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
        }
        //------------------------------------------------------------------------------------
        if ($typ == 0) {
            $firmy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Firma')->find($id);
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($firmy);
            $em->flush();

            $przejazdFirmy = $this->getDoctrine()
                    ->getRepository('MyKilometrowkaBundle:Przejazd')
                    ->findBy(array('idFirmy' => $id));
            foreach ($przejazdFirmy as $row) {
                $em->remove($row);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_firmy'));
        }

        if ($typ == 1) {
            $pojazd = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pojazd')->find($id);
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($pojazd);
            $em->flush();

            $przejazdPojazdu = $this->getDoctrine()
                    ->getRepository('MyKilometrowkaBundle:Przejazd')
                    ->findBy(array('idPojazdu' => $id));
            foreach ($przejazdPojazdu as $row) {
                $em->remove($row);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_pojazdy'));
        }

        if ($typ == 2) {
            $trasa = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Trasa')->find($id);
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($trasa);
            $em->flush();

            $przejazdTrasy = $this->getDoctrine()
                    ->getRepository('MyKilometrowkaBundle:Przejazd')
                    ->findBy(array('idTrasy' => $id));
            foreach ($przejazdTrasy as $row) {
                $em->remove($row);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_trasy'));
        }

        if ($typ == 3) {
            $trasa = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pracownik')->find($id);
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($trasa);
            $em->flush();

            $przejazdPracownika = $this->getDoctrine()
                    ->getRepository('MyKilometrowkaBundle:Przejazd')
                    ->findBy(array('idPracownika' => $id));
            foreach ($przejazdPracownika as $row) {
                $em->remove($row);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_pracownicy'));
        }

        if ($typ == 4) {
            $trasa = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Przejazd')->find($id);
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($trasa);
            $em->flush();
            return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_przejazdy'));
        }


        return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_firmy'));
    }

    public function dodajFirmeAction(Request $reques, $id) {
        //------------------------------------------------------------------------------------
        if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
        }
        //------------------------------------------------------------------------------------
        if (($id == '-1') || !isset($id)) {
            //-1 oznacza że dodajemy firme, a nie edytujemy
            if ($reques->getMethod() == 'POST') {
                $firma = new Firma();
                $firma->setNazwaFirmy($this->get('request')->request->get('nazwaFirmy'));
                $firma->setAdres($this->get('request')->request->get('adres'));
                $firma->setKodPocztowy($this->get('request')->request->get('kodPocztowy'));
                $firma->setMiasto($this->get('request')->request->get('miasto'));
                $firma->setNip($this->get('request')->request->get('nip'));
                $firma->setRegon($this->get('request')->request->get('regon'));
                $idUzytkownika = $reques->getSession()->get('user');
                $iddd = $idUzytkownika[0]->getId();
                $firma->setIdUzytkownika($iddd);
                $edycjaId = $this->get('request')->request->get('edycjaId');

                if (!isset($edycjaId)) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($firma);
                    $em->flush();
                    return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_firmy', array('blad' => 2)));
                } else {
                    $em = $this->getDoctrine()->getManager();
                    $firmy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Firma')->find($edycjaId);

                    //@TODO REDUDANCJA! USUŃ Z PROTOTYPA + funckja setUpdateId w encji Firma.php
                    $firmy->setNazwaFirmy($this->get('request')->request->get('nazwaFirmy'));
                    $firmy->setAdres($this->get('request')->request->get('adres'));
                    $firmy->setKodPocztowy($this->get('request')->request->get('kodPocztowy'));
                    $firmy->setMiasto($this->get('request')->request->get('miasto'));
                    $firmy->setNip($this->get('request')->request->get('nip'));
                    $firmy->setRegon($this->get('request')->request->get('regon'));

                    $em->persist($firmy);
                    $em->flush();
                    return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_firmy', array('blad' => 3)));
                }
            }
        } else {
            $firmy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Firma')->find($id);
            return $this->render('MyKilometrowkaBundle:Login:dodajFirme.html.twig', array(
                        'edycja' => '1',
                        'firmy' => $firmy, 'user' => $user
            ));
        }
        return $this->render('MyKilometrowkaBundle:Login:dodajFirme.html.twig', array('edycja' => '0', 'user' => $user, 'blad' => 'lol'));
    }

    public function dodajTraseAction(Request $reques, $id) {
        //------------------------------------------------------------------------------------
        if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
        }
        //------------------------------------------------------------------------------------
        if (($id == '-1') || !isset($id)) {
            //-1 oznacza że dodajemy firme, a nie edytujemy
            if ($reques->getMethod() == 'POST') {
                $trasa = new Trasa();
                $trasa->setDokad($this->get('request')->request->get('dokad'));
                $trasa->setNazwa($this->get('request')->request->get('nazwa'));
                $trasa->setOdleglosc($this->get('request')->request->get('odleglosc'));
                $trasa->setOpis($this->get('request')->request->get('opis'));
                $trasa->setSkad($this->get('request')->request->get('skad'));
                $idUzytkownika = $reques->getSession()->get('user');
                $iddd = $idUzytkownika[0]->getId();
                $trasa->setIdUzytkownika($iddd);
//                $trasa->setRegon($this->get('r;equest')->request->get('regon'));
                $edycjaId = $this->get('request')->request->get('edycjaId');

                if (!isset($edycjaId)) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($trasa);
                    $em->flush();
                    return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_trasy', array('blad' => 2)));
                } else {
                    $em = $this->getDoctrine()->getManager();
                    $trasy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Trasa')->find($edycjaId);

                    //@TODO REDUDANCJA! USUŃ Z PROTOTYPA + funckja setUpdateId w encji Firma.php
                    $trasy->setDokad($this->get('request')->request->get('dokad'));
                    $trasy->setNazwa($this->get('request')->request->get('nazwa'));
                    $trasy->setOdleglosc($this->get('request')->request->get('odleglosc'));
                    $trasy->setOpis($this->get('request')->request->get('opis'));
                    $trasy->setSkad($this->get('request')->request->get('skad'));

                    $em->persist($trasy);
                    $em->flush();
                    return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_trasy', array('blad' => 3)));
                }
            }
        } else {
            $trasy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Trasa')->find($id);
            return $this->render('MyKilometrowkaBundle:Login:dodajTrase.html.twig', array(
                        'edycja' => '1',
                        'trasy' => $trasy, 'user' => $user
            ));
        }
        return $this->render('MyKilometrowkaBundle:Login:dodajTrase.html.twig', array('edycja' => '0', 'user' => $user));
    }

    public function dodajPojazdAction(Request $reques, $id) {
        //------------------------------------------------------------------------------------
        if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
        }
        //------------------------------------------------------------------------------------
        if (($id == '-1') || !isset($id)) {
            //-1 oznacza że dodajemy firme, a nie edytujemy
            if ($reques->getMethod() == 'POST') {
                $pojazd = new Pojazd();
                $pojazd->setNazwa($this->get('request')->request->get('nazwa'));
                $pojazd->setNumerRejestracyjny($this->get('request')->request->get('numerRejestracyjny'));
                $pojazd->setOpis($this->get('request')->request->get('opis'));
                $pojazd->setPojemnoscSilnika($this->get('request')->request->get('pojemnoscSilnika'));
                //@TODO DODAJ STAWKE KLASE! 0.5214
                $stawka = new Stawka();
                $pojazd->setStawka('1.0');
                $idUzytkownika = $reques->getSession()->get('user');
                $iddd = $idUzytkownika[0]->getId();
                $pojazd->setIdUzytkownika($iddd);
                $edycjaId = $this->get('request')->request->get('edycjaId');

                if (!isset($edycjaId)) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($pojazd);
                    $em->flush();
                    return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_pojazdy', array('blad' => 2)));
                } else {
                    $em = $this->getDoctrine()->getManager();
                    $pojazdy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pojazd')->find($edycjaId);

                    //@TODO REDUDANCJA! USUŃ Z PROTOTYPA + funckja setUpdateId w encji Firma.php
                    $pojazdy->setNazwa($this->get('request')->request->get('nazwa'));
                    $pojazdy->setNumerRejestracyjny($this->get('request')->request->get('numerRejestracyjny'));
                    $pojazdy->setOpis($this->get('request')->request->get('opis'));
                    $pojazdy->setPojemnoscSilnika($this->get('request')->request->get('pojemnoscSilnika'));
                    //@TODO DODAJ STAWKE KLASE! 0.5214
                    $stawka = new Stawka();
                    $pojazdy->setStawka('1.0');

                    $em->persist($pojazdy);
                    $em->flush();
                    return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_pojazdy', array('blad' => 3)));
                }
            }
        } else {
            $pojazdy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pojazd')->find($id);
            return $this->render('MyKilometrowkaBundle:Login:dodajPojazd.html.twig', array(
                        'edycja' => '1',
                        'pojazdy' => $pojazdy, 'user' => $user
            ));
        }
        return $this->render('MyKilometrowkaBundle:Login:dodajPojazd.html.twig', array('edycja' => '0', 'user' => $user));
    }

    public function dodajPracownikaAction(Request $reques, $id) {
        //------------------------------------------------------------------------------------
        if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
        }
        //------------------------------------------------------------------------------------
        if (($id == '-1') || !isset($id)) {
            //-1 oznacza że dodajemy firme, a nie edytujemy
            if ($reques->getMethod() == 'POST') {
                $pracownik = new Pracownik();
                $pracownik->setAdres($this->get('request')->request->get('adres'));
                $pracownik->setImie($this->get('request')->request->get('imie'));
                $pracownik->setKodPocztowy($this->get('request')->request->get('kodPocztowy'));
                $pracownik->setMiasto($this->get('request')->request->get('miasto'));
                $pracownik->setNazwisko($this->get('request')->request->get('nazwisko'));
                $pracownik->setTelefon($this->get('request')->request->get('telefon'));
                $idUzytkownika = $reques->getSession()->get('user');
                $iddd = $idUzytkownika[0]->getId();
                $pracownik->setIdUzytkownika($iddd);
                $edycjaId = $this->get('request')->request->get('edycjaId');

                if (!isset($edycjaId)) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($pracownik);
                    $em->flush();
                    return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_pracownicy', array('blad' => 2)));
                } else {
                    $em = $this->getDoctrine()->getManager();
                    $firmy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pracownik')->find($edycjaId);

                    //@TODO REDUDANCJA! USUŃ Z PROTOTYPA + funckja setUpdateId w encji Firma.php
                    $firmy->setAdres($this->get('request')->request->get('adres'));
                    $firmy->setImie($this->get('request')->request->get('imie'));
                    $firmy->setKodPocztowy($this->get('request')->request->get('kodPocztowy'));
                    $firmy->setMiasto($this->get('request')->request->get('miasto'));
                    $firmy->setNazwisko($this->get('request')->request->get('nazwisko'));
                    $firmy->setTelefon($this->get('request')->request->get('telefon'));

                    $em->persist($firmy);
                    $em->flush();
                    return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_pracownicy', array('blad' => 3)));
                }
            }
        } else {
            $pracownicy = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pracownik')->find($id);
            return $this->render('MyKilometrowkaBundle:Login:dodajPracownika.html.twig', array(
                        'edycja' => '1',
                        'pracownicy' => $pracownicy, 'user' => $user
            ));
        }
        return $this->render('MyKilometrowkaBundle:Login:dodajPracownika.html.twig', array('edycja' => '0', 'user' => $user));
    }

    public function dodajPrzejazdAction(Request $reques, $id) {
        //------------------------------------------------------------------------------------
        if (!$user = Logowanie::czyZalogowano($this->getRequest()->getSession(), $reques)) {
            return $this->redirect($this->generateUrl('my_kilometrowka_logowanie'));
        }
        //------------------------------------------------------------------------------------
        if (($id == '-1') || !isset($id)) {
            //-1 oznacza że dodajemy przejazd, a nie edytujemy
            if ($reques->getMethod() == 'POST') {

                $firma = $this->getDoctrine()
                        ->getRepository('MyKilometrowkaBundle:Firma')
                        ->findBy(array('id' => $this->get('request')->request->get('idFirmy')));
                $trasa = $this->getDoctrine()
                        ->getRepository('MyKilometrowkaBundle:Trasa')
                        ->findBy(array('id' => $this->get('request')->request->get('idTrasy')));
                $pracownik = $this->getDoctrine()
                        ->getRepository('MyKilometrowkaBundle:Pracownik')
                        ->findBy(array('id' => $this->get('request')->request->get('idPracownika')));

                $pojazd = $this->getDoctrine()
                        ->getRepository('MyKilometrowkaBundle:Pojazd')
                        ->findBy(array('id' => $this->get('request')->request->get('idPojazdu')));

                $nazwaFirmy = $firma[0]->getNazwaFirmy();
                $nazwaPojazdu = $pojazd[0]->getNazwa();
                $nazwaPracownika = $pracownik[0]->getImie() . ' ' . $pracownik[0]->getNazwisko();
                $nazwaTrasy = $trasa[0]->getNazwa();
                $odlegloscTrasy = $trasa[0]->getOdleglosc();



                $przejazd = new Przejazd();
                $przejazd->setAdnotacje($this->get('request')->request->get('adnotacje'));
                $przejazd->setCelWyjazdu($this->get('request')->request->get('celWyjazdu'));
                //----
                $stawka = new Stawka();
                $em = $this->getDoctrine()->getManager();
                $typPojazdu = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pojazd')->find($this->get('request')->request->get('idPojazdu'));
                $pojemnosc = $typPojazdu->getPojemnoscSilnika();
                //----
                $przejazd->setCena($pojemnosc);
                $przejazd->setData(new \DateTime($this->get('request')->request->get('data')));
                $przejazd->setIdFirmy($this->get('request')->request->get('idFirmy'));
                $przejazd->setIdPojazdu($this->get('request')->request->get('idPojazdu'));
                $przejazd->setIdPracownika($this->get('request')->request->get('idPracownika'));
                $przejazd->setIdTrasy($this->get('request')->request->get('idTrasy'));
                $datka = new \DateTime($this->get('request')->request->get('data'));
                $datka = date_format($datka, '1-m-Y');
                $przejazd->setMiesiacIRok(new \DateTime($datka));
                $przejazd->setNazwaFirmy($nazwaFirmy);
                $przejazd->setNazwaPojazdu($nazwaPojazdu);
                $przejazd->setNazwaPracownika($nazwaPracownika);
                $przejazd->setNazwaTrasy($nazwaTrasy);
                $przejazd->setOdlegloscTrasy($odlegloscTrasy);
                $idUzytkownika = $reques->getSession()->get('user');
                $iddd = $idUzytkownika[0]->getId();
                $przejazd->setIdUzytkownika($iddd);
//

                $edycjaId = $this->get('request')->request->get('edycjaId');

                if (!isset($edycjaId)) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($przejazd);
                    $em->flush();
                    return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_przejazdy'));
                } else {
                    $em = $this->getDoctrine()->getManager();
                    $przejazdyEdytuj = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Przejazd')->find($edycjaId);

                    //@TODO REDUDANCJA! USUŃ Z PROTOTYPA + funckja setUpdateId w encji Firma.php

                    $firma = $this->getDoctrine()
                            ->getRepository('MyKilometrowkaBundle:Firma')
                            ->findBy(array('id' => $this->get('request')->request->get('idFirmy')));
                    $trasa = $this->getDoctrine()
                            ->getRepository('MyKilometrowkaBundle:Trasa')
                            ->findBy(array('id' => $this->get('request')->request->get('idTrasy')));
                    $pracownik = $this->getDoctrine()
                            ->getRepository('MyKilometrowkaBundle:Pracownik')
                            ->findBy(array('id' => $this->get('request')->request->get('idPracownika')));

                    $pojazd = $this->getDoctrine()
                            ->getRepository('MyKilometrowkaBundle:Pojazd')
                            ->findBy(array('id' => $this->get('request')->request->get('idPojazdu')));

                    $nazwaFirmy = $firma[0]->getNazwaFirmy();
                    $nazwaPojazdu = $pojazd[0]->getNazwa();
                    $nazwaPracownika = $pracownik[0]->getImie() . ' ' . $pracownik[0]->getNazwisko();
                    $nazwaTrasy = $trasa[0]->getNazwa();
                    $odlegloscTrasy = $trasa[0]->getOdleglosc();



                    $przejazdyEdytuj->setAdnotacje($this->get('request')->request->get('adnotacje'));
                    $przejazdyEdytuj->setCelWyjazdu($this->get('request')->request->get('celWyjazdu'));
                    //----
                    $stawka = new Stawka();
                    $em = $this->getDoctrine()->getManager();
                    $typPojazdu = $this->getDoctrine()->getRepository('MyKilometrowkaBundle:Pojazd')->find($this->get('request')->request->get('idPojazdu'));
                    $pojemnosc = $typPojazdu->getPojemnoscSilnika();
                    //----
                    $przejazdyEdytuj->setCena($pojemnosc);
                    $przejazdyEdytuj->setData(new \DateTime($this->get('request')->request->get('data')));
                    $przejazdyEdytuj->setIdFirmy($this->get('request')->request->get('idFirmy'));
                    $przejazdyEdytuj->setIdPojazdu($this->get('request')->request->get('idPojazdu'));
                    $przejazdyEdytuj->setIdPracownika($this->get('request')->request->get('idPracownika'));
                    $przejazdyEdytuj->setIdTrasy($this->get('request')->request->get('idTrasy'));
                    $datka = new \DateTime($this->get('request')->request->get('data'));
                    $datka = date_format($datka, '1-m-Y');
                    $przejazdyEdytuj->setMiesiacIRok(new \DateTime($datka));
                    $przejazdyEdytuj->setNazwaFirmy($nazwaFirmy);
                    $przejazdyEdytuj->setNazwaPojazdu($nazwaPojazdu);
                    $przejazdyEdytuj->setNazwaPracownika($nazwaPracownika);
                    $przejazdyEdytuj->setNazwaTrasy($nazwaTrasy);
                    $przejazdyEdytuj->setOdlegloscTrasy($odlegloscTrasy);

                    $em->persist($przejazdyEdytuj);
                    $em->flush();
                    return $this->redirect($this->generateUrl('my_kilometrowka_zalogowany_przejazdy'));
                }
            }
        } else {

            //DODAWANIE PRZEJAZDÓW wyślij mu dane---------------
            $idUzytkownika = $reques->getSession()->get('user');
            $iddd = $idUzytkownika[0]->getId();

            $przejazdy = $this->getDoctrine()
                    ->getRepository('MyKilometrowkaBundle:Przejazd')
                    ->findBy(array('idUzytkownika' => $iddd));

            $pobierzDostepnePojazdy = $this->getDoctrine()
                    ->getRepository('MyKilometrowkaBundle:Pojazd')
                    ->findBy(array('idUzytkownika' => $iddd));

            $pobierzDostepneTrasy = $this->getDoctrine()
                    ->getRepository('MyKilometrowkaBundle:Trasa')
                    ->findBy(array('idUzytkownika' => $iddd));

            $pobierzDostepneFirmy = $this->getDoctrine()
                    ->getRepository('MyKilometrowkaBundle:Firma')
                    ->findBy(array('idUzytkownika' => $iddd));

            $pobierzDostepnychPracownikow = $this->getDoctrine()
                    ->getRepository('MyKilometrowkaBundle:Pracownik')
                    ->findBy(array('idUzytkownika' => $iddd));

            if (NULL == $przejazdy) {
                throw $this->createNotFoundException('Nie znaleziono takiego przejazdu');
            }

            //pobieranie po ID nazw 

            $listaPojazdow = array();
            $listaTras = array();
            $listaFirm = array();
            $listaPracownikow = array();

            $i = 0;
            foreach ($pobierzDostepnePojazdy as $row) {
                $listaPojazdow[$i] = $row;
                $i++;
            }

            $i = 0;
            foreach ($pobierzDostepneTrasy as $row) {
                $listaTras[$i] = $row;
                $i++;
            }

            $i = 0;
            foreach ($pobierzDostepneFirmy as $row) {
                $listaFirm[$i] = $row;
                $i++;
            }

            $i = 0;
            foreach ($pobierzDostepnychPracownikow as $row) {
                $listaPracownikow[$i] = $row;
                $i++;
            }

            $jedenPrzejazd = $this->getDoctrine()
                    ->getRepository('MyKilometrowkaBundle:Przejazd')
                    ->find($id);

            return $this->render('MyKilometrowkaBundle:Login:dodajPrzejazd.html.twig', array(
                        'edycja' => '1',
                        'pojazdy' => $listaPojazdow,
                        'trasy' => $listaTras,
                        'firmy' => $listaFirm,
                        'pracownicy' => $listaPracownikow,
                        'przejazdy' => $jedenPrzejazd,
                        'user' => $user
            ));
        }
        //DODAWANIE PRZEJAZDÓW wyślij mu dane---------------
        $idUzytkownika = $reques->getSession()->get('user');
        $iddd = $idUzytkownika[0]->getId();
        $przejazdy = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Przejazd')
                ->findBy(array('idUzytkownika' => $iddd));

        $pobierzDostepnePojazdy = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Pojazd')
                ->findBy(array('idUzytkownika' => $iddd));

        $pobierzDostepneTrasy = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Trasa')
                ->findBy(array('idUzytkownika' => $iddd));

        $pobierzDostepneFirmy = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Firma')
                ->findBy(array('idUzytkownika' => $iddd));

        $pobierzDostepnychPracownikow = $this->getDoctrine()
                ->getRepository('MyKilometrowkaBundle:Pracownik')
                ->findBy(array('idUzytkownika' => $iddd));

        if (NULL == $przejazdy) {
            //throw $this->createNotFoundException('Nie znaleziono takiego przejazdu');
        }

        //pobieranie po ID nazw 
        $listaPojazdow = array();
        $listaTras = array();
        $listaFirm = array();
        $listaPracownikow = array();

        $i = 0;
        foreach ($pobierzDostepnePojazdy as $row) {
            $listaPojazdow[$i] = $row;
            $i++;
        }

        $i = 0;
        foreach ($pobierzDostepneTrasy as $row) {
            $listaTras[$i] = $row;
            $i++;
        }

        $i = 0;
        foreach ($pobierzDostepneFirmy as $row) {
            $listaFirm[$i] = $row;
            $i++;
        }

        $i = 0;
        foreach ($pobierzDostepnychPracownikow as $row) {
            $listaPracownikow[$i] = $row;
            $i++;
        }

        return $this->render('MyKilometrowkaBundle:Login:dodajPrzejazd.html.twig', array(
                    'edycja' => '0',
                    'pojazdy' => $listaPojazdow,
                    'trasy' => $listaTras,
                    'firmy' => $listaFirm,
                    'pracownicy' => $listaPracownikow,
                    'user' => $user
        ));
    }

}
