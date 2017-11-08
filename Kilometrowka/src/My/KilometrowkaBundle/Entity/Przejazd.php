<?php

namespace My\KilometrowkaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Przejazd
 */
class Przejazd {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $idPojazdu;

    /**
     * @var string
     */
    private $idTrasy;

    /**
     * @var string
     */
    private $idFirmy;

    /**
     * @var string
     */
    private $idPracownika;

    /**
     * @var string
     */
    private $celWyjazdu;

    /**
     * @var string
     */
    private $adnotacje;

    /**
     * @var \DateTime
     */
    private $data;

    /**
     * @var string
     */
    private $odlegloscTrasy;

    /**
     * @var string
     */
    private $nazwaPojazdu;

    /**
     * @var string
     */
    private $nazwaFirmy;

    /**
     * @var string
     */
    private $nazwaPracownika;

    /**
     * @var string
     */
    private $nazwaTrasy;

    /**
     * @var \DateTime
     */
    private $miesiacIRok;

    /**
     * @var string
     */
    private $cena;
    private $idUzytkownika;

    /**
     * Set nazwaFirmy
     *
     * @param string $nazwaFirmy
     * @return Firma
     */
    public function setIdUzytkownika($idUzytkownika) {
        $this->idUzytkownika = $idUzytkownika;

        return $this;
    }

    /**
     * Get nazwaFirmy
     *
     * @return string 
     */
    public function getIdUzytkownika() {
        return $this->idUzytkownika;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set idPojazdu
     *
     * @param string $idPojazdu
     * @return Przejazd
     */
    public function setIdPojazdu($idPojazdu) {
        $this->idPojazdu = $idPojazdu;

        return $this;
    }

    /**
     * Get idPojazdu
     *
     * @return string 
     */
    public function getIdPojazdu() {
        return $this->idPojazdu;
    }

    /**
     * Set idTrasy
     *
     * @param string $idTrasy
     * @return Przejazd
     */
    public function setIdTrasy($idTrasy) {
        $this->idTrasy = $idTrasy;

        return $this;
    }

    /**
     * Get idTrasy
     *
     * @return string 
     */
    public function getIdTrasy() {
        return $this->idTrasy;
    }

    /**
     * Set idFirmy
     *
     * @param string $idFirmy
     * @return Przejazd
     */
    public function setIdFirmy($idFirmy) {
        $this->idFirmy = $idFirmy;

        return $this;
    }

    /**
     * Get idFirmy
     *
     * @return string 
     */
    public function getIdFirmy() {
        return $this->idFirmy;
    }

    /**
     * Set idPracownika
     *
     * @param string $idPracownika
     * @return Przejazd
     */
    public function setIdPracownika($idPracownika) {
        $this->idPracownika = $idPracownika;

        return $this;
    }

    /**
     * Get idPracownika
     *
     * @return string 
     */
    public function getIdPracownika() {
        return $this->idPracownika;
    }

    /**
     * Set celWyjazdu
     *
     * @param string $celWyjazdu
     * @return Przejazd
     */
    public function setCelWyjazdu($celWyjazdu) {
        $this->celWyjazdu = $celWyjazdu;

        return $this;
    }

    /**
     * Get celWyjazdu
     *
     * @return string 
     */
    public function getCelWyjazdu() {
        return $this->celWyjazdu;
    }

    /**
     * Set adnotacje
     *
     * @param string $adnotacje
     * @return Przejazd
     */
    public function setAdnotacje($adnotacje) {
        $this->adnotacje = $adnotacje;

        return $this;
    }

    /**
     * Get adnotacje
     *
     * @return string 
     */
    public function getAdnotacje() {
        return $this->adnotacje;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     * @return Przejazd
     */
    public function setData($data) {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime 
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Set odlegloscTrasy
     *
     * @param string $odlegloscTrasy
     * @return Przejazd
     */
    public function setOdlegloscTrasy($odlegloscTrasy) {
        $this->odlegloscTrasy = $odlegloscTrasy;

        return $this;
    }

    /**
     * Get odlegloscTrasy
     *
     * @return string 
     */
    public function getOdlegloscTrasy() {
        return $this->odlegloscTrasy;
    }

    /**
     * Set nazwaPojazdu
     *
     * @param string $nazwaPojazdu
     * @return Przejazd
     */
    public function setNazwaPojazdu($nazwaPojazdu) {
        $this->nazwaPojazdu = $nazwaPojazdu;

        return $this;
    }

    /**
     * Get nazwaPojazdu
     *
     * @return string 
     */
    public function getNazwaPojazdu() {
        return $this->nazwaPojazdu;
    }

    /**
     * Set nazwaFirmy
     *
     * @param string $nazwaFirmy
     * @return Przejazd
     */
    public function setNazwaFirmy($nazwaFirmy) {
        $this->nazwaFirmy = $nazwaFirmy;

        return $this;
    }

    /**
     * Get nazwaFirmy
     *
     * @return string 
     */
    public function getNazwaFirmy() {
        return $this->nazwaFirmy;
    }

    /**
     * Set nazwaPracownika
     *
     * @param string $nazwaPracownika
     * @return Przejazd
     */
    public function setNazwaPracownika($nazwaPracownika) {
        $this->nazwaPracownika = $nazwaPracownika;

        return $this;
    }

    /**
     * Get nazwaPracownika
     *
     * @return string 
     */
    public function getNazwaPracownika() {
        return $this->nazwaPracownika;
    }

    /**
     * Set nazwaTrasy
     *
     * @param string $nazwaTrasy
     * @return Przejazd
     */
    public function setNazwaTrasy($nazwaTrasy) {
        $this->nazwaTrasy = $nazwaTrasy;

        return $this;
    }

    /**
     * Get nazwaTrasy
     *
     * @return string 
     */
    public function getNazwaTrasy() {
        return $this->nazwaTrasy;
    }

    /**
     * Set miesiacIRok
     *
     * @param \DateTime $miesiacIRok
     * @return Przejazd
     */
    public function setMiesiacIRok($miesiacIRok) {
        $this->miesiacIRok = $miesiacIRok;

        return $this;
    }

    /**
     * Get miesiacIRok
     *
     * @return \DateTime 
     */
    public function getMiesiacIRok() {
        return $this->miesiacIRok;
    }

    /**
     * Set cena
     *
     * @param string $cena
     * @return Przejazd
     */
    public function setCena($cena) {
        $this->cena = $cena;

        return $this;
    }

    /**
     * Get cena
     *
     * @return string 
     */
    public function getCena() {
        return $this->cena;
    }

}
