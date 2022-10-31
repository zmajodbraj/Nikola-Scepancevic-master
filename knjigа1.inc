<?php
class Knjiga{
	public $glNaslov;
	public $autor1;
	public $autor2;
	public $izdanje; 
	public $mesto_izdavac;
	public $naziv_izdavac;
	public $godina_izdavanja;
        public $materijalnipodaci;
	public function __construct($nasl,$izd1,$publcity, $publname, $publyear,$aut1,$aut2){
	  $this->glNaslov=$nasl;
	  $this->izdanje=$izd1;
	  $this->mesto_izdavac=$publcity; 
	  $this->naziv_izdavac=$publname;
	  $this->godina_izdavanja=$publyear;
	  $this->autor1=$aut1;
	  $this->autor2=$aut2;
	}
	public function getNaslov(){
	  return $this->glNaslov;
	}
	public function getIzdanje(){
	  return $this->izdanje;
	}
	public function getMesto_izdavac(){
	  return $this->mesto_izdavac;
	}
	public function getNaziv_izdavac(){
	  return $this->naziv_izdavac;
	}
	public function getGodina_izdavanja(){
	  return $this->godina_izdavanja;
	}
	public function getAutor1(){
	  return $this->autor1;
	}
	public function getAutor2(){
	  return $this->autor2;
	}
} 
?>
