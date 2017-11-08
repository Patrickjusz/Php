<?php

namespace My\KilometrowkaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trasa
 */
class Trasa {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nazwa;

    /**
     * @var string
     */
    private $skad;

    /**
     * @var string
     */
    private $dokad;

    /**
     * @var string
     */
    private $odleglosc;

    /**
     * @var string
     */
    private $opis;
    
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
     * Set nazwa
     *
     * @param string $nazwa
     * @return Trasa
     */
    public function setNazwa($nazwa) {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string 
     */
    public function getNazwa() {
        return $this->nazwa;
    }

    /**
     * Set skad
     *
     * @param string $skad
     * @return Trasa
     */
    public function setSkad($skad) {
        $this->skad = $skad;

        return $this;
    }

    /**
     * Get skad
     *
     * @return string 
     */
    public function getSkad() {
        return $this->skad;
    }

    /**
     * Set dokad
     *
     * @param string $dokad
     * @return Trasa
     */
    public function setDokad($dokad) {
        $this->dokad = $dokad;

        return $this;
    }

    /**
     * Get dokad
     *
     * @return string 
     */
    public function getDokad() {
        return $this->dokad;
    }

    /**
     * Set odleglosc
     *
     * @param string $odleglosc
     * @return Trasa
     */
    public function setOdleglosc($odleglosc) {
        $this->odleglosc = $odleglosc;

        return $this;
    }

    /**
     * Get odleglosc
     *
     * @return string 
     */
    public function getOdleglosc() {
        return $this->odleglosc;
    }

    /**
     * Set opis
     *
     * @param string $opis
     * @return Trasa
     */
    public function setOpis($opis) {
        $this->opis = $opis;

        return $this;
    }

    /**
     * Get opis
     *
     * @return string 
     */
    public function getOpis() {
        return $this->opis;
    }

}
