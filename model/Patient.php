<?php


namespace model;


class Patient
{
    private $id;
    private $naam;
    private $adres;
    private $woonplaats;
    private $zknummer;
    private $geboortedatum;
    private $soortverzekering;
    //with this u get a variable that u asked for
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
    //with this u set or change a variable u chose
    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return $this;
    }

}