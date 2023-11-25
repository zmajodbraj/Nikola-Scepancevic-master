<?php
session_start();

require('knjiga2.inc');

$knjige3=$_SESSION["MyVar"];

$xml3 = simplexml_load_string($knjige3) or die("Ne mogu da otvorim string knjige3 za parsiranje.");
        
$knjige=array(); 
$n=0;
  foreach($xml3->children() as $zapisi){
    $naslov="";$izd="";$izdsed="";$izdnaziv=""; $izdgod="";$a1="";$a2="";$odrednica="";$mater="";$izdcel="";$napomene="";$isbn="";$inv="";
    foreach($zapisi->children() as $polja){
       $p701a=0; $p701b=0; 
       $ozn_polje=$polja->getName();
       $polje=$polja;
       switch ($ozn_polje){
         case "p200a" :
          $naslov=$polje;
          $odrednica=$polje;
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
            $a1=$polje;
            break;
         case "p700b" :
            $odrednica = $a1 . ", " . $polje;
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
            $isbn=$polje;
            break;
        case "p995f" :
            $inv .=$polje;
            break;
         case "p995k" :
            $inv .= "=" . $polje . "; ";
            break;
         default :

       }
     }
     $knjige[]=new Knjiga($odrednica,$naslov, $izd, $izdsed,$izdnaziv, $izdgod,$a1,$a2,$mater, $izdcel, $napomene, $isbn, $inv);
     $n++;
    }

     function cmp($a, $b)
     {
      return strcmp($a->getNaslov(), $b->getNaslov());
     }
     usort($knjige, "cmp");
     $str="";
     $str="<html>\n";
     $str.=" <head>\n";
     $str.="  <title>Tabelarni prikaz</title>\n";
     $str.=" </head>\n";
     $str.=" <body>\n";
     $str .= "  <table>\n"; // zapocinjemo tabelu
     $str .= "<tr><th>Redni broj</th><th>Naslov</th><th>Autor(i)</th><th>Izdanje</th><th>Mesto izdavanja</th><th>Izdavac</th><th>Godina izdavanja</th><th>Materijalni opis</th><th>Izdavacka celina</th><th>Sifra zapisa</th><th>Napomene</th><th>ISBN broj</th><th>Inv broj</th></tr>\n"; //dodajemo zaglavlje kolona
     for($i=0;$i<$n;$i++){ 
    $str .= "<tr>"; //zapocinjemo vrstu tabele
    $str .= "<td>"l $str1=$i+1; $str .= $str1; $str .= "</td>";  //generisemo redni broj i smestamo ga u polje tabele   
    $str .= "<td>"; $str1=$knjige[$i]->getNaslov(); $str .= $str1; $str .= "</td>"; //uzimamo podatak o naslovu i smestamo ga u polje tabele 
    $str .= "<td>"; $str1=$knjige[$i]->getAutor1(); $str .= $str1; $str1=$knjige[$i]->getAutor2(); $str .= $str1; $str .= "</td>"; //uzimamo podatke o autorima i smestamo ga u polje tabele 
    $str .= "<td>"; $str1=$knjige[$i]->getIzdanje(); $str .= $str1;  $str .= "</td>"; //uzimamo podatak o izdanju i smestamo ga u polje tabele
    $str .= "<td>"; $str1=$knjige[$i]->getMesto_izdavac(); $str .= $str1; $str .= "</td>"; //uzimamo podatak sediste izdavaca i smestamo ga u polje tabele
    $str .= "<td>"; $str1=$knjige[$i]->getNaziv_izdavac(); $str .= $str1; $str .= "</td>"; //uzimamo podatak o nazivu izdavaca i smestamo ga u polje tabele
    $str .= "<td>"; $str1=$knjige[$i]->getGodina_izdavanja(); $str .= $str1; $str .= "</td>"; //uzimamo podatak o godini izdavanja i smestamo ga u polje tabele
    $str .= "<td>"; $str1=$knjige[$i]->getMatopis(); $str .= $str1; $str .= "</td>"; //uzimamo podatak o materijalnom opisu i smestamo ga u polje tabele
    $str .= "<td>"; $str1=$knjige[$i]->getIzdcelina(); $str .= $str1; $str .= "</td>"; //uzimamo podatak o izdavackoj celini i smestamo ga u polje tabele
    $str .= "<td>"; $str1=$knjige[$i]->getNapomene(); $str .= $str1; $str .= "</td>"; //uzimamo podatak o napomenama i smestamo ga u polje tabele
    $str .= "<td>"; $str1=$knjige[$i]->getISBN(); $str .= $str1; $str .= "</td>"; //uzimamo podatak o ISBN broju i smestamo ga u polje tabele
    $str .= "<td>"; $str1=$knjige[$i]->getInvbr(); $str .= $str1; $str .= "</td>";//uzimamo podatak o inventarskim brojevima i smestamo ih u polje tabele
    $str .= "</tr>\n"; //zavrsavamo vrstu
     }     
    $str .= "  </table>\n"; //zavrsavamo tabelu
  $str.=" </body>\n";
  $str.="</html>\n";

     echo $str;//prikazemo tabelu
  session_unset($_SESSION["MyVar"]);
  session_destroy();
?>
