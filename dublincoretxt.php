<?php
session_start();
$sadrzaj="";
$knjige3=$_SESSION["MyVar"];	
/*  Drugi prolazak kroz simple xml parser */
$xml3 = simplexml_load_string($knjige3) or die("Ne mogu da otvorim string knjige3 za parsiranje.");
$hdr='<?xml version="1.0" encoding="utf-8" ?>\n';
$sadrzaj.=$hdr; //dodajemo zaglavlje xml fajla

$str="<records>\n";          
$sadrzaj.=$str; //dodamo otvoreni tag za sve zapise
       foreach($xml3->children() as $zapisi){
	  /*izdvajaju se podaci o naslovu, izdanju, izdavanju, autorima, i materijalnom opisu. */ 
    $naslov="";$izd="";$izdsed="";$izdnaziv=""; $izdgod="";$a1="";$a2="";$matopis="";$strcont1="";$strcont2="";
    $str="  <record>\n";
    $sadrzaj.=$str; //dodamo otvoreni tag za svaki pojedinacni zapis
    foreach($zapisi->children() as $polja){
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
            $matopis=$polje;
            break;
         case "p215c" :
            $matopis .= " : " . $polje;
            break;
         case "p215d" :
            $matopis .= " ; " . $polje;
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
            $strcont1="    <dc_author>" . $a1 . "</dc_author>\n";
            break;
         case "p701a" :
            $prezime=$polje;
           break;
         case "p701b" :
            $auti=$polje;
            $autp=$prezime;
            $strcont2 .= "    <dc_author>" . $auti . " " . $autp . "</dc_author>\n";
            break;
         case "p710a" :
            $a1=$polje;
            break;
         case "p710d" :
            $a1 .= " (" . $polje;
            break;
         case "p710f" :
            $a1 .= " ; " . $polje;
            break;
         case "p710e" :
            $a1 .= " ; " . $polje . ")";
            $strcont1 .= "    <dc_author>" . $a1 . "</dc_author>\n" ;
            break;
         default :
        
        }
       }
	  /* formira se Dublin core format  */ 
       $str="    <dc_creator>Bibloteka Matematickog fakulteta</dc_creator>\n";
       $sadrzaj.=$str;
       $str1=date("d.m.Y");		
       $str="    <dc_date>" . $str1 . ". </dc_date>\n";
       $sadrzaj.=$str;
       $str="    <dc_publisher>" . $izdsed . " : " . $izdnaziv . ", " . $izdgod . "</dc_publisher>\n";
       $sadrzaj.=$str;
       $sadrzaj.=$strcont1;
       $sadrzaj.=$strcont2;
       $str="    <dc_format>" . $matopis . "</dc_format>\n";
       $sadrzaj.=$str;
       $str="    <dc_type>Text </dc_type>\n";
       $sadrzaj.=$str);
       $str="    <dc_title>" . $naslov . "</dc_title>\n";
       $sadrzaj.=$str;
       $str="    <dc_subject></dc_subject>\n";
       $sadrzaj.=$str; 
       $str="    <dc_description></dc_description>\n";
       $sadrzaj.=$str;
       $str="  </record>\n";
       $sadrzaj.=$str; // dodamo zatvoreni tag za svaki pojedinacni zapis,

     }
     $str="</records>\n"; //dodamo zatvoreni tag za sve zapise
     $sadrzaj.=$str;
     header('Content-disposition: attachment; filename=dublincore.xml');
     header ("Content-Type:  text/xml");
     echo $sadrzaj;

   session_unset($_SESSION["MyVal"]);//oslobadjamo $_SESSION promenljivu,
   session_destroy(); //uklanjamo sesiju
?>
