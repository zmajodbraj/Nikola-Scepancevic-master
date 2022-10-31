<?php

chmod("knjige3.xml",0755);

$xml3 = simplexml_load_file("knjige3.xml") or die("Ne mogu da otvorim knjige3.xml za parsiranje.");
if(file_exists('dublincore.xml')) unlink('dublincore.xml');
$myfile=fopen("dublincore.xml", "w") or die("Ne mogu da otvorim dublincore.xml za upis");
fwrite($myfile,$hdr);
$str="<records>\n";          
fwrite($myfile, $str);
  foreach($xml3->children() as $zapisi){
    $naslov="";$izd="";$izdsed="";$izdnaziv=""; $izdgod="";$a1="";$a2="";$odrednica="";$mater="";$izdcel="";$sifzapisa="";$napomene="";$isbn=""; $inv="";
    $str="  <record>\n";
    fwrite($myfile, $str);
    $strcont="";
    foreach($zapisi->children() as $polja){
       $p701a=0;$p701b=0; 
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
            $odrednica=$polje;
            $a1=$polje;
            break;
         case "p700b" :
            $odrednica .= ", " . $polje;
            $auti=$polje;
            $autp=$a1;
            $a1=$auti . " " . $autp;
            $strcont="    <dc_contributor>" . $a1 . "</dc_contributor>\n";
            break;
         case "p701a" :
           //$p701a++;
           $prezime=$polje;
           break;
         case "p701b" :
           // $p701b++;
            $auti=$polje;
            $autp=$prezime;
            $strcont .= "    <dc_contributor>" . $auti . " " . $autp . "</dc_contributor>\n";
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
       $str="    <dc_creator>Nikola Scepancevic, Miljana Todorovic, Snezana Colakovic</dc_creator>\n";
       fwrite($myfile, $str);
       $str1=date("d.m.Y");		
       $str="    <dc_date>" . $str1 . ". </dc_date>\n";
       fwrite($myfile, $str);
       $str="    <dc_publisher>" . $izdsed . " : " . $izdnaziv . ", " . $izdgod . "</dc_publisher>\n";
       fwrite($myfile, $str);
       fwrite($myfile, $strcont);
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
