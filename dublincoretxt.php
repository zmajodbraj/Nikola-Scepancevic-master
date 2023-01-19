<?php

chmod("knjige3.xml",0755);
/*  Drugi prolazak kroz simple xml parser */
$xml3 = simplexml_load_file("knjige3.xml") or die("Ne mogu da otvorim knjige3.xml za parsiranje.");
if(file_exists('dublincore.xml')) unlink('dublincore.xml');
$myfile=fopen("dublincore.xml", "w") or die("Ne mogu da otvorim dublincore.xml za upis");
fwrite($myfile,$hdr);
$str="<records>\n";          
fwrite($myfile, $str);
  foreach($xml3->children() as $zapisi){
	  /*izdvajaju se podaci o naslovu, izdanju, izdavanju, autorima, i materijalnom opisu. */ 
    $naslov="";$izd="";$izdsed="";$izdnaziv=""; $izdgod="";$a1="";$a2="";$mater="";$strcont1="";$strcont2="";
    $str="  <record>\n";
    fwrite($myfile, $str);
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
            $strcont1="    <dc_contributor>" . $a1 . "</dc_contributor>\n";
            break;
         case "p701a" :
         
           $prezime=$polje;
           break;
         case "p701b" :
            $auti=$polje;
            $autp=$prezime;
            $strcont2 .= "    <dc_contributor>" . $auti . " " . $autp . "</dc_contributor>\n";
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
            $strcont1 .= $a1;
            break;
         default :
        
        }
       }
	  /* formira se Dublin core format  */
       $str="    <dc_creator>Nikola Scepancevic, Miljana Todorovic, Snezana Colakovic</dc_creator>\n";
       fwrite($myfile, $str);
       $str1=date("d.m.Y");		
       $str="    <dc_date>" . $str1 . ". </dc_date>\n";
       fwrite($myfile, $str);
       $str="    <dc_publisher>" . $izdsed . " : " . $izdnaziv . ", " . $izdgod . "</dc_publisher>\n";
       fwrite($myfile, $str);
       fwrite($myfile, $strcont1);
       fwrite($nyfule, $strcont2);
       $str="    <dc_format>" . $mater . "</dc_format>\n";
       fwrite($myfile, $str);
       $str="    <dc_type>Text </dc_type>\n";
       fwrite($myfile, $str);
       $str="    <dc_title>" . $naslov . "</dc_title>\n";
       fwrite($myfile, $str);
       $str="    <dc_subject></dc_subject>\n";
       fwrite($myfile, $str); 
       $str="    <dc_description></dc_description>\n";
       fwrite($myfile, $str);
       $str="  </record>\n";
       fwrite($myfile, $str);

     }
     $str="</records>\n";
     fwrite($myfile, $str);
     fclose($myfile);
     $str="";
     $myfile=fopen("dublincore.xml", "r");
     while(!feof($myfile)){
        $str .= fgetc($myfile);
     }
     fclose($myfile);
     header('Content-disposition: attachment; filename=dublincore.xml');
     header ("Content-Type:  text/xml");
     echo $str;
?>
