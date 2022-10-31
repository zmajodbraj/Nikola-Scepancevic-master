<?php

require("knjiga1.inc");


chmod("knjige3.xml",0755);

$xml3 = simplexml_load_file("knjige3.xml") or die("Ne mogu da otvorim knjige3.xml za parsiranje.");

        
$knjige=array(); 
$n=0;
  foreach($xml3->children() as $zapisi){
    $naslov="";$izd="";$izdsed="";$izdnaziv=""; $izdgod="";$a1="";$a2="";
    foreach($zapisi->children() as $polja){
       $p701a=0;$p701b=0; 
       $ozn_polje=$polja->getName();
       $polje=$polja;
//       echo $ozn_polje . " " . $polje . "<br>";
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
         case "p700a" :
            $a1=$polje;
            break;
         case "p700b" :
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
            $a1=$polje;
            break;
         default :

       }
     }

     $knjige[]=new Knjiga($naslov, $izd, $izdsed,$izdnaziv, $izdgod,$a1,$a2);
     $n++;
    }
     function cmp($a, $b)
     {
      return strcmp($a->getGodina_izdavanja(), $b->getGodina_izdavanja());
     }
     usort($knjige, "cmp");
     header("Content-type: application/vnd.ms-word");
     header("Content-Disposition: attachment;Filename=bibliography.docx");
     header("Content-Type: text/html; charset=utf-8");
     echo "<html>\n";  
     echo "<head><title>Bibliografija</title></head>\n"; 
     echo "<body>\n";
     echo "<p align=\"center\">Bibliograafija</p>";   
    
     echo "<ol>\n";
     for($i=0;$i<$n;$i++){ 
     echo "<li>";  $str=$knjige[$i]->getAutor1(); echo $str;  $str=$knjige[$i]->getAutor2(); echo $str; echo " : ";
     $str=$knjige[$i]->getNaslov(); echo $str;
     $str=$knjige[$i]->getIzdanje();
     if ($str !== "") 
       echo ". - " . $str;
     echo ". - "; $str=$knjige[$i]->getMesto_izdavac(); echo $str;
     echo " : "; $str=$knjige[$i]->getNaziv_izdavac(); echo $str;
     echo ", "; $str=$knjige[$i]->getGodina_izdavanja(); echo $str; 
     echo "</li>\n"; 
     }     
    echo "</ol>\n";  
    echo "</body>\n";
    echo "</html>";
?>
