<?php

namespace My\KilometrowkaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Firma
 */
class Firma {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nazwaFirmy;

    /**
     * @var string
     */
    private $adres;

    /**
     * @var string
     */
    private $miasto;

    /**
     * @var string
     */
    private $kodPocztowy;

    /**
     * @var string
     */
    private $nip;

    /**
     * @var string
     */
    private $regon;

    /**
     * @var integer
     */
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
     * Set nazwaFirmy
     *
     * @param string $nazwaFirmy
     * @return Firma
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
     * Set adres
     *
     * @param string $adres
     * @return Firma
     */
    public function setAdres($adres) {
        $this->adres = $adres;

        return $this;
    }

    /**
     * Get adres
     *
     * @return string 
     */
    public function getAdres() {
        return $this->adres;
    }

    /**
     * Set miasto
     *
     * @param string $miasto
     * @return Firma
     */
    public function setMiasto($miasto) {
        $this->miasto = $miasto;

        return $this;
    }

    /**
     * Get miasto
     *
     * @return string 
     */
    public function getMiasto() {
        return $this->miasto;
    }

    /**
     * Set kodPocztowy
     *
     * @param string $kodPocztowy
     * @return Firma
     */
    public function setKodPocztowy($kodPocztowy) {
        $this->kodPocztowy = $kodPocztowy;

        return $this;
    }

    /**
     * Get kodPocztowy
     *
     * @return string 
     */
    public function getKodPocztowy() {
        return $this->kodPocztowy;
    }

    /**
     * Set nip
     *
     * @param string $nip
     * @return Firma
     */
    public function setNip($nip) {
        $this->nip = $nip;

        return $this;
    }

    /**
     * Get nip
     *
     * @return string 
     */
    public function getNip() {
        return $this->nip;
    }

    /**
     * Set regon
     *
     * @param string $regon
     * @return Firma
     */
    public function setRegon($regon) {
        $this->regon = $regon;

        return $this;
    }

    /**
     * Get regon
     *
     * @return string 
     */
    public function getRegon() {
        return $this->regon;
    }

    public function setUpdateId($id) {
        $this->id = $id;
        return $this;
    }

}
