<?php

namespace My\KilometrowkaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pracownik
 */
class Pracownik {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $imie;

    /**
     * @var string
     */
    private $nazwisko;

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
    private $telefon;
    
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
     * Set imie
     *
     * @param string $imie
     * @return Pracownik
     */
    public function setImie($imie) {
        $this->imie = $imie;

        return $this;
    }

    /**
     * Get imie
     *
     * @return string 
     */
    public function getImie() {
        return $this->imie;
    }

    /**
     * Set nazwisko
     *
     * @param string $nazwisko
     * @return Pracownik
     */
    public function setNazwisko($nazwisko) {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    /**
     * Get nazwisko
     *
     * @return string 
     */
    public function getNazwisko() {
        return $this->nazwisko;
    }

    /**
     * Set adres
     *
     * @param string $adres
     * @return Pracownik
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
     * @return Pracownik
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
     * @return Pracownik
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
     * Set telefon
     *
     * @param string $telefon
     * @return Pracownik
     */
    public function setTelefon($telefon) {
        $this->telefon = $telefon;

        return $this;
    }

    /**
     * Get telefon
     *
     * @return string 
     */
    public function getTelefon() {
        return $this->telefon;
    }

}
