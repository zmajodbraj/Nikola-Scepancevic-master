<?php
/* Ukljucimo fajl sa definicijom objkta; za razliku od formata bibliografija, izvestaj ISBD je obimniji */
require("knjiga2.inc");


chmod("knjige3.xml",0755);

/*U drugom prolazu kroz simplexml parser, izdvajaju se polja za sve elemente bibliografskog opisa:
odrednica
naslov,
autori, 
izdanje,
podaci o izdavacu, 
materijalni opis,
podaci o izdavackoj celini, 
napomene,
ISBN broj, 
i inventarski broj; 
tako se formira niz objekata tipa knjiga. */
$xml3 = simplexml_load_file("knjige3.xml") or die("Ne mogu da otvorim knjige3.xml za parsiranje.");
        
$knjige=array(); 
$n=0;
  foreach($xml3->children() as $zapisi){
    $naslov="";$izd="";$izdsed="";$izdnaziv=""; $izdgod="";$a1="";$a2="";$odrednica="";$mater="";$izdcel="";$napomene="";$isbn=""; $inv="";
    foreach($zapisi->children() as $polja){
       $p701a=0;$p701b=0; 
       $ozn_polje=$polja->getName();
       $polje=$polja;

       switch ($ozn_polje){
         case "p200a" :
           $odrednica=$polje;
           $naslov=$polje;
           break;
         case "p200d" :
           $naslov .= " = " . $polje;
           break;
         case "p200e" :
           $naslov .= " : " . $polje;
           break;
         case "p205a" :
           $izd = $polje;
           break;
         case "p210a" :
           $izdsed=$polje;
           break;
         case "p210c" :
            $izdnaziv=$polje;
            break;
         case "p210d" :
            $izdgod=$polje;
            break;
         case "p215a" :
            $mater=$polje;
            break;
         case "p215c" :
            $mater .= " : " . $polje;
            break;
         case "p215d" :
            $mater .= " ; " . $polje;
            break;
         case "p215e" :
            $mater .= " + " . $polje;
            break;
         case "p700a" :
            $odrednica=$polje;
            $a1=$polje;
            break;
         case "p700b" :
            $odrednica .= ", " . $polje;
            $auti=$polje;
            $autp=$a1;
            $a1=$auti . " " . $autp;
            break;
         case "p701a" :
           //$p701a++;
           $prezime=$polje;
           break;
         case "p701b" :
           // $p701b++;
            $auti=$polje;
            $autp=$prezime;
            $a2 .= ", " . $auti . " " . $autp;
            break;
         case "p710a" :
            $odrednica=$polje;
            $a1=$polje;
            break;
         case "p710d" :
            $odrednica .= " (" . $polje;
            break;
         case "p710f" :
            $odrednica .= " ; " . $polje;
            break;
         case "p710e" :
            $odrednica .= " ; " . $polje . ")";
            break;
         case "p225a" :
            $izdcel= $polje;
            break;
	 case "p225v" : 
            $izdcel .= " ; " . $polje;
	    break;
         case "p327a" :
            $napomene .= $polje;
            $napomene .= ". ";
            break;
         case "p010a" :
            $isbn= $polje;
            break;
         case "p995f" :
            $inv .=$polje;
            break;
         case "p995k" :
            $inv .= "=" . $polje . " <br> ";
            break;
         default :

       }
     }
     $knjige[]=new Knjiga($odrednica,$naslov, $izd, $izdsed,$izdnaziv, $izdgod,$a1,$a2,$mater, $izdcel, $napomene, $isbn, $inv);
     $n++;
    }
/* Sortiranje u alfabetskom poretku po odrednici. */
     function cmp($a, $b)
     {
      return strcmp($a->getOdrednica(), $b->getOdrednica());
     }
     usort($knjige, "cmp");

/* Formiranje word dokumenta u ISBD formatu */

     header("Content-type: application/vnd.ms-word");
     header("Content-Disposition: attachment;Filename=reportISBD.docx");
     header("Content-Type: text/html; charset=utf-8");
     echo "<html>";  
     echo "<head><title>Izvestaj ISBD</title></head>"; 
     echo "<body>";
     echo "<p align=\"center\">Izveštaj ISBD</p>";   
     echo "<ol>";
     for($i=0;$i<$n;$i++){ 
     echo "<li>"; $str=$knjige[$i]->getOdrednica(); echo $str; echo '<br>';
     echo "&nbsp";echo "&nbsp";echo "&nbsp";echo "&nbsp"; $str=$knjige[$i]->getNaslov();  echo $str; echo " / "; $str=$knjige[$i]->getAutor1(); echo $str; 
$str=$knjige[$i]->getAutor2(); echo $str;  
     $str=$knjige[$i]->getIzdanje();
     if ($str !== "") 
       echo ". - " . $str;
     echo ". - "; $str=$knjige[$i]->getMesto_izdavac(); echo $str;
     echo " : "; $str=$knjige[$i]->getNaziv_izdavac(); echo $str;
     echo ", "; $str=$knjige[$i]->getGodina_izdavanja(); echo $str; 
     $str=$knjige[$i]->getMatopis(); 
     if ($str!=="")
        echo ". - " . $str;
     $str=$knjige[$i]->getIzdcelina();
     if ($str !== ""){
       echo ". - ("; echo $str; echo ")";
     }
     echo "<br>";
     $str = $knjige[$i]->getNapomene(); 
     if ( $str !== "")
        echo $str; 
     $str= $knjige[$i]->getISBN();
     if ($str !==""){
        echo " ISBN "; echo $str; 
     }
     echo "<br>";
     $str=$knjige[$i]->getInvbr();
     echo $str;
     echo "</li>"; echo "<br>";
     }     
    echo "</ol>";  
    echo "</body>";
    echo "</html>";
?>
