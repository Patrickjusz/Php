<?php

namespace My\KilometrowkaBundle\Utils;

class Stawka {

    private $stawkaDo900;
    private $stawkaPowyzej900;
    private $stawkaMotorower;
    private $stawkaMotocykl;

    function __construct() {
        $this->stawkaDo900 = 0.5214;
        $this->stawkaPowyzej900 = 0.8358;
        $this->stawkaMotocykl = 0.2302;
        $this->stawkaMotorower = 0.1382;
    }

    public function getStawkaDo900() {
        return $this->stawkaDo900;
    }

    public function getStawkaPowyzej900() {
        return $this->stawkaPowyzej900;
    }

    public function getStawkaMotorower() {
        return $this->stawkaMotorower;
    }

    public function getStawkaMotocykl() {
        return $this->stawkaMotocykl;
        }

        public function policzStawke($a, $b) {
        return $a * $b;
    }

}
