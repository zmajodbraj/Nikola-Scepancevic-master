<?php


require("knjiga2.inc");


chmod("knjige3.xml",0755);

$xml3 = simplexml_load_file("knjige3.xml") or die("Ne mogu da otvorim knjige3.xml za parsiranje.");
        
$knjige=array(); 
$n=0;
  foreach($xml3->children() as $zapisi){
    $naslov="";$izd="";$izdsed="";$izdnaziv=""; $izdgod="";$a1="";$a2="";$odrednica="";$mater="";$izdcel="";$sifzapisa="";$napomene="";$isbn=""; $inv="";
    foreach($zapisi->children() as $polja){
       $p701a=0;$p701b=0; 
       $ozn_polje=$polja->getName();
       $polje=$polja;
       switch ($ozn_polje){
         case "p200a" :
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
/*         case "p327a" :
            $napomene .= $polje;
            $napomene .= ". ";
            break;*/
         case "p010a" :
            $isbn= $polje;
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

 
     header("Content-Type: text/html; charset=utf-8");
     echo "<html>\n";  
     echo "<head><title>Izvestaj</title></head>\n"; 
     echo "<body>\n";
     echo "<table>\n";
echo "<tr><td>Naslov</td><td>Autor(i)</td><td>Izdanje</td><td>Mesto izdavanja</td><td>Izdavac</td><td>Godina izdavanja</td><td>Materijalni opis</td><td>Izdavacka celina</td><td>ISBN broj</td><td>Inv broj</td></tr><br>";
     for($i=0;$i<$n;$i++){ 
     echo "<tr>";echo "<td>"; $str=$knjige[$i]->getNaslov();  echo $str; echo "</td><td>";  $str=$knjige[$i]->getAutor1(); echo $str;  $str=$knjige[$i]->getAutor2(); echo $str; echo "</td><td>"; 
     $str=$knjige[$i]->getIzdanje();
 
       echo $str; echo "</td><td>";
    $str=$knjige[$i]->getMesto_izdavac(); echo $str; echo "</td><td>";
    $str=$knjige[$i]->getNaziv_izdavac(); echo $str;
     echo "</td><td>"; $str=$knjige[$i]->getGodina_izdavanja(); echo $str; echo "</td><td>"; 
     $str=$knjige[$i]->getMatopis(); 
             echo $str;echo "</td><td>";
     $str=$knjige[$i]->getIzdcelina();
      echo $str; echo "</td><td>";        
     $str2= $knjige[$i]->getISBN(); echo $str2; echo "</td>"; echo "<td>"; $str2=$knjige[$i]->getInvbr(); echo $str2; echo "</td>"; echo "</tr>\n"; 
     }     
    echo "</table>\n";  
    echo "</body>\n";
    echo "</html>\n";
?>
