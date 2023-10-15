<?php
session_start();

$knjige3=$_SESSION["MyVar"];

$xml3 = simplexml_load_string($knjige3) or die("Ne mogu da otvorim string knjige3 za parsiranje.");
$str="";
//zapocinjemo xml fajl sa zaglavljem
$hdr="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
$str.=$hdr;
//otvaramo tag za skup zapisa i povezujemo se sa definicijom elemenata Dublin core
$str.="<records xmlns:dc=\"http://purl.org/dc/elements/1.1/\">\n";          
  foreach($xml3->children() as $zapisi){
    $naslov="";$izd="";$izdsed="";$izdnaziv=""; $izdgod="";$a1="";$a2="";$odrednica="";$mater="";$izdcel="";$sifzapisa="";$napomene="";$isbn=""; $inv="";
    $str.="  <record>\n";//dodajemo otvoreni tag za pojedinacni zapis
    $strcont="";
    foreach($zapisi->children() as $polja){
     
       $ozn_polje=$polja->getName();
       $polje=$polja;
//       echo $ozn_polje . " " . $polje . "<br>";
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
            $a1=$polje;
            break;
         case "p700b" :
            $auti=$polje;
            $autp=$a1;
            $a1=$auti . " " . $autp;
            $strauth="    <dc:contributor.author>" . $a1 . "</dc:contributor.author>\n";
            break;
         case "p701a" :
           $prezime=$polje;
           break;
         case "p701b" :
            $auti=$polje;
            $autp=$prezime;
            $strauth .= "    <dc:contributor.author>" . $auti . " " . $autp . "</dc:contributor.author>\n";
            break;
         case "p710a" :
            $a1=$polje;
            break;
         case "p710d" :
            $a1.= " (" . $polje;
            break;
         case "p710f" :
            $a1.= " ; " . $polje;
            break;
         case "p710e" :
            $a1 .= " ; " . $polje . ")";
            $strauth .= "    <dc:contributor.author>" . $a1 . "</dc:contributor.author>\n";
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
            $inv .= "=" . $polje . "  ";
            break;
         default :
        
        }
       }
       $str.="    <dc:creator>Biblioteka Matemati&#269;kog fakulteta</dc:creator>\n";
       $str1=$izdgod;		
       $str.="    <dc:date>" . $str1 . ". </dc:date>\n";
       
       $str.="    <dc:publisher>" . $izdsed . " : " . $izdnaziv . "</dc:publisher>\n";
       
       $str.=$strauth; 
       $str.="    <dc:format>" . $mater . "</dc:format>\n";
       $str.="    <dc:type>Text </dc:type>\n";
       $str.="    <dc:title>" . $naslov . "</dc:title>\n";
       $str.="    <dc:subject></dc:subject>\n";
       $str.="    <dc:description></dc:description>\n";
       $str.="  </record>\n";//zatvaramo tag za pojedinacni zapis
       

     }
     $str.="</records>\n"; //zatvaramo tag za skup zapisa
   
     header('Content-disposition: attachment; filename=dublincore.xml');//kreiramo izlazni fajl 
     header('Content-Type:  text/xml');
     echo $str;//ispisujemo sadrzaj u fajl

     session_unset($_SESSION["MyVar"]);
     session_destroy();
?>
