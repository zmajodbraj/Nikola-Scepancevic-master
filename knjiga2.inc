<?php
class Knjiga{
	public $odrednica;
        public $glNaslov;
	public $autor1;
	public $autor2;
	public $izdanje; 
	public $mesto_izdavac;
	public $naziv_izdavac;
	public $godina_izdavanja;
        public $matopis;
        public $izdcelina;
	public $napomene;
        public $isbn;
        public $invbr;
	public function __construct($odredn,$nasl,$izd1,$publcity, $publname, $publyear,$aut1,$aut2, $matdesc, $series,$notes,$isbnnum, $specimen){
	  $this->odrednica=$odredn;
	  $this->glNaslov=$nasl;
	  $this->izdanje=$izd1;
	  $this->mesto_izdavac=$publcity; 
	  $this->naziv_izdavac=$publname;
	  $this->godina_izdavanja=$publyear;
	  $this->autor1=$aut1;
	  $this->autor2=$aut2;
          $this->matopis=$matdesc;
          $this->izdcelina=$series;
  	  $this->napomene=$notes;
	  $this->isbn=$isbnnum;
          $this->invbr=$specimen;
	}
        public function getOdrednica(){
          return $this->odrednica;
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
	public function getMatopis(){
	  return $this->matopis;
	}
	public function getIzdcelina(){
	  return $this->izdcelina;
	}
	public function getNapomene(){
	  return $this->napomene;
	}
        public function getISBN(){
          return $this->isbn;
        }
	public function getInvbr(){
          return $this->invbr;
	}
} 
?>
