<?php

namespace My\KilometrowkaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pojazd
 */
class Pojazd
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var float
     */
    private $stawka;

    /**
     * @var string
     */
    private $nazwa;

    /**
     * @var string
     */
    private $numerRejestracyjny;

    /**
     * @var string
     */
    private $pojemnoscSilnika;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set stawka
     *
     * @param float $stawka
     * @return Pojazd
     */
    public function setStawka($stawka)
    {
        $this->stawka = $stawka;

        return $this;
    }

    /**
     * Get stawka
     *
     * @return float 
     */
    public function getStawka()
    {
        return $this->stawka;
    }

    /**
     * Set nazwa
     *
     * @param string $nazwa
     * @return Pojazd
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string 
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * Set numerRejestracyjny
     *
     * @param string $numerRejestracyjny
     * @return Pojazd
     */
    public function setNumerRejestracyjny($numerRejestracyjny)
    {
        $this->numerRejestracyjny = $numerRejestracyjny;

        return $this;
    }

    /**
     * Get numerRejestracyjny
     *
     * @return string 
     */
    public function getNumerRejestracyjny()
    {
        return $this->numerRejestracyjny;
    }

    /**
     * Set pojemnoscSilnika
     *
     * @param string $pojemnoscSilnika
     * @return Pojazd
     */
    public function setPojemnoscSilnika($pojemnoscSilnika)
    {
        $this->pojemnoscSilnika = $pojemnoscSilnika;

        return $this;
    }

    /**
     * Get pojemnoscSilnika
     *
     * @return string 
     */
    public function getPojemnoscSilnika()
    {
        return $this->pojemnoscSilnika;
    }

    /**
     * Set opis
     *
     * @param string $opis
     * @return Pojazd
     */
    public function setOpis($opis)
    {
        $this->opis = $opis;

        return $this;
    }

    /**
     * Get opis
     *
     * @return string 
     */
    public function getOpis()
    {
        return $this->opis;
    }
}
